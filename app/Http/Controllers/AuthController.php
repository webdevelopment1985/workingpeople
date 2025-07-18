<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helper\CryptoAPI;
use DB;
use Log;
use Mail;
use Session;
use Carbon\Carbon;
use Exception;

class AuthController extends Controller
{

    private $cryptoAPI;

    public function __construct()
    {
        $this->cryptoAPI = new CryptoAPI();
    }
    

    public function showLandingpage()
    {
        return view('templates.Landing_page.index');
    }

    public function Privacy_policy()
    {
        return view('templates.Landing_page.privacy');
    }
    public function Terms_condition()
    {
        return view('templates.Landing_page.terms');
    }
    public function showLoginForm()
    {
        return view('templates.auth.login');
    }

    public function sendEmail(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);
    
        try {
            Mail::send('templates.emails.sendemail', [
                'name' => $data['name'],
                'email' => $data['email'],
                'userMessage' => $data['message'] // Rename the variable

            ], function ($message) use ($data) {
                $message->to( env('MAIL_FROM_ADDRESS')); // Send to the admin email
                $message->from($data['email'], $data['name']); // From the user's email and name
                $message->subject('User Query');
            });
    
            return response()->json(['success' => 'Email sent successfully.']);
    
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Mail sending failed: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
    
            // Return detailed error message in response (only for debugging, not in production)
            return response()->json([
                'error' => 'Failed to send email.',
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }
    

    public function login(Request $request)
    {
        if(\Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif(\Auth::check() && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        $identity = $request->input('email');
        $loginType = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([
            $loginType => $identity,
            'password' => $request->password
        ]);

        $validatedData = $request->validate([
            'g-recaptcha-response' => 'required|captcha'
        ]);
        if (Auth::attempt($request->only($loginType, 'password'))) {
            if (Auth::user()->isAdmin()) {
                $otp = random_int(100000, 999999);
                Auth::user()->login_otp = $otp;
                Auth::user()->otp_sent_at = time();
                Auth::user()->save();
                Mail::send('templates.emails.adminLoginOTP', ['token' => $otp], function ($message) use ($request) {
                    $message->to(Auth::user()->email);
                    $message->subject('Admin Login OTP');
                });
                return redirect()->route('admin.dashboard');
            } else {
                $is_verified = Auth::user()->is_verified;
                if(!$is_verified){
                    $apiResponse = $this->cryptoAPI->make_api_call('send_otp', [
                        "Type" => "1",
                        "Email"=>Auth::user()->email
                    ]);
                    $logData = [
                        'request'=>[
                            "Type" => "1",
                            "Email"=>Auth::user()->email
                        ],
                        'response'=>$apiResponse
                    ];                
                    \Log::info('cryptoResponse:resend_login_otp['.Auth::user()->email.']' . json_encode($logData));
                }
                else{
                    $narration = Auth::user()->username . " user login";
                    add_user_logs(Auth::user()->id, 'login', $narration);
                }
                return redirect()->route('dashboard');
            }
        }
        return redirect()->back()->withInput($request->only('email'))->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }

    public function showRegisterForm(Request $request)
    {
        if(\Auth::check()) {
            return redirect()->route('dashboard');
        }
        $dataForView = array();
        if($request->sponsor) {
            $sponsor = strtolower($request->sponsor);
            $isValidSponsor = User::where('username', $sponsor)->first();
            if(!$isValidSponsor) {
                Session::flash('error', 'Invalid referral link');
                return redirect()->route('register');
            }
        } else {
            $defaultSponsor = User::where('sponsor', 0)->first();
            if($defaultSponsor) {
                $sponsor = $defaultSponsor->username;
            } else {
                $sponsor = 'fintradepool';
            }
        }
        $dataForView['sponsor'] = $sponsor;
        return view('templates.auth.register', $dataForView);
    }
    
    public function register(Request $request)
    {

        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|alpha_num|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'checkbox' =>'required',
            'g-recaptcha-response' => 'required|captcha'
        ], [
            'name.required'=>'Please enter your full name',
            'email.required'=>'Please enter email address',
            'username.required' => 'Please enter username',
            'username.alpha_num' => 'Only alphanumeric chars are allowed for username.',
            'password.required'=>'Please enter password',
            'password.confirmed'=>'Password and confirm password must be same',
            'checkbox' =>'Please Select Privacy Policy & Terms.'
        ]);
        $sponsor_id = 1;
        if($request->input('sponsor')) {
            $sponsor = strtolower($request->input('sponsor'));
            $sponsorExist = User::where('username', $sponsor)->where('is_paid', 1)->first();
            if($sponsorExist) {
                $sponsor_id = $sponsorExist->id;
            } else {
                Session::flash('error', 'Please enter valid IB');
                return redirect()->route('register');
            }
        }
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => strtolower($validatedData['email']),
            'username' => strtolower($validatedData['username']),
            'sponsor'=>$sponsor_id,
            'password' => Hash::make($validatedData['password']),
            'users_type' => 1,
            'uuid'=>(string) Str::uuid()
        ]);
        if($user->id) {
            try {
                $apiResponse = $this->cryptoAPI->make_api_call('send_otp', [
                    "Type" => "1",
                    "Email"=>$validatedData['email']
                ]);
                $logData = [
                    'request'=>[
                        "Type" => "1",
                        "Email"=>$validatedData['email']
                    ],
                    'response'=>$apiResponse
                ];
                \Log::info('cryptoResponse:send_otp['.$validatedData['email'].']' . json_encode($logData));

                if($apiResponse->message == 'success' && isset($apiResponse->details)) {
                    if(Auth::attempt(["email"=>$validatedData['email'], "password"=>$validatedData['password']])) {
                        Auth::user()->otp_sent_at = time();
                        Auth::user()->save();
                        Session::flash('success', 'Please enter otp sent on your email address');
                        return redirect()->route('register-confirm');
                    }
                } else {
                    Log::info('register API failed Response for {User}', ['User' => $validatedData['email'], 'apiResponse'=>$apiResponse]);
                }
            } catch(Exception $e) {
                Log::error('register[send_otp] API Exception : ', ['message'=>$e->getMessage()]);
                Session::flash('error', 'Server did not respond. Please try after sometime.');
                return redirect()->route('register-confirm');
            }
        }
        return redirect('/login');
    }

    public function showForgetPasswordForm()
    {
        return view('templates.auth.forget_password');
    }

    /**
       * Write code on Method
       *
       * @return response()
       */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ], [
            'email.required'=>'Please enter email address',
            'email.email'=>'Please enter valid email address',
            'email.exists'=>'Email address does not exists'
        ]);
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
          ]);
  
        Mail::send('templates.emails.forgotPassword', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });
  

        return back()->with('message', 'We have e-mailed your password reset link !! ');
    }

    /**
       * Write code on Method
       *
       * @return response()
       */
    public function showResetPasswordForm($token)
    {
        return view('templates.auth.reset_password', ['token' => $token]);
    }


    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);
        $updatePassword = DB::table('password_resets')
        ->where([
            'email' => $request->email,
            'token' => $request->token
        ])
        ->first();
        if(!$updatePassword) {
            return back()->withInput()->with('error', 'Your link has either expired or invalid !!');
        }
  
        $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
 
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
        return redirect('/login')->with('message', 'Your password has been changed!');
    }

    public function logout(Request $request)
    {
        if(Auth::user()->users_type == 2){
            $narration = Auth::user()->username . " logout successfully";
            add_admin_logs(Auth::user()->id, 'logout', $narration); 
        }
        else{
            $narration = Auth::user()->username . " logout successfully";
            add_user_logs(Auth::user()->id, 'logout', $narration);
        }        
        Auth::logout();
        return redirect('/login');
    }

    public function showRegisterFormConfirm()
    {
        $dataForView = array();
        if(\Auth::check()) {
            $dataForView['email'] = Auth::user()->email;
            return view('templates.auth.registerconfirm', $dataForView);
        } else {
            return redirect('/login');
        }
    }

    public function postRegisterFormConfirm(Request $request)
    {
        if(\Auth::check()) {
            $validatedData = $request->validate([
                'confirm_otp' => 'required|max:6'
            ], [
                'confirm_otp.required'=>'Please enter otp sent on your email'
            ]);
            $confirm_otp = $request->confirm_otp;
            $user = Auth::user();
            try {
                $apiResponse = $this->cryptoAPI->make_api_call('verify_otp', [
                    "Type" => "1",
                    "VerifyCode"=>$confirm_otp,
                    "UserID"=>Auth::user()->username,
                    "Email"=>$user->email
                ]);

                $logData = [
                    'request'=>[
                        "Type" => "1",
                        "VerifyCode"=>$confirm_otp,
                        "UserID"=>Auth::user()->username,
                        "Email"=>$user->email
                    ],
                    'response'=>$apiResponse
                ];
                \Log::info('cryptoResponse:verify_otp['.$user->email.']' . json_encode($logData));

                if($apiResponse->message == 'success') {
                    Auth::user()->is_verified = 1;
                    Auth::user()->status = 1;
                    Auth::user()->otp_sent_at = null;
                    Auth::user()->save();
                    $param = $user->id;
                    
                    DB::select('CALL addLevelRecord(?)', [$param]);

                    return redirect()->route('dashboard');
                } elseif($apiResponse->message == 'failed' && isset($apiResponse->details)) {
                    Log::info('postRegisterFormConfirm[verify_otp] API Exception : ', ['apiResponse'=>$apiResponse]);
                    return redirect()->back()->withErrors(['confirm_otp'=>$apiResponse->details]);
                } else {
                    Log::info('postRegisterFormConfirm[verify_otp] API Exception : ', ['apiResponse'=>$apiResponse]);
                    return redirect()->back()->withErrors(['confirm_otp'=>'Invalid OTP']);
                }
            } catch(Exception $e) {
                Log::error('postRegisterFormConfirm[verify_otp] API Exception : ', ['message'=>$e->getMessage()]);
                return redirect()->back()->withErrors(['confirm_otp'=>'Server did not respond. Please try after sometime.']);
            }
        } else {
            return redirect('/login');
        }
    }

    public function resendConfirmOTP(Request $request)
    {
        if(\Auth::check()) {
            $user = User::where('email', Auth::user()->email)->first();
            $currentTime = time();
            $time = $user->otp_sent_at;
            
            if($currentTime >= $time && $time >= $currentTime - (60+5)) {
                return response()->json(['success' => false,'message'=> 'Please wait for 60 seconds before sending new OTP']);
            }

            try {
                $apiResponse = $this->cryptoAPI->make_api_call('send_otp', [
                    "Type" => "1",
                    "Email"=>Auth::user()->email
                ]);

                $logData = [
                    'request'=>[
                        "Type" => "1",
                        "Email"=>Auth::user()->email
                    ],
                    'response'=>$apiResponse
                ];
                \Log::info('cryptoResponse:resend_confirm_otp['.$user->email.']' . json_encode($logData));

                if($apiResponse->message == 'success' && isset($apiResponse->details)) {
                    Auth::user()->otp_sent_at = time();
                    Auth::user()->save();
                    return response()->json(['success' => true,'message'=> $apiResponse->details]);
                } elseif($apiResponse->message == 'failed' && isset($apiResponse->details)) {
                    return response()->json(['success' => false,'message'=> $apiResponse->details]);
                } else {
                    return response()->json(['success' => false,'message'=> 'Something went wrong.']);
                }
            } catch(Exception $e) {
                Log::error('resendConfirmOTP[send_otp] API Exception : ', ['message'=>$e->getMessage()]);
                return response()->json(['success' => false,'message'=> 'Server did not respond. Please try after sometime.']);
            }
        } else {
            return response()->json(['success' => false,'message'=> 'Unauthorized access']);
        }
    }

    public function resendAdminLoginOTP(Request $request)
    {
        if(\Auth::check()) {
            $user = User::where('email', Auth::user()->email)->first();
            $currentTime = time();
            $time = $user->otp_sent_at;
            if($currentTime >= $time && $time >= $currentTime - (60+1)) {
                return response()->json(['success' => false,'message'=> 'Please wait for 60 seconds before sending new OTP']);
            }
            try {
                $otp = random_int(100000, 999999);
                Auth::user()->login_otp = $otp;
                Auth::user()->otp_sent_at = time();
                Auth::user()->save();
                Mail::send('templates.emails.adminLoginOTP', ['token' => $otp], function ($message) use ($request) {
                    $message->to(Auth::user()->email);
                    $message->subject('Admin Login OTP');
                });
                return response()->json(['success' => true,'message'=> 'OTP sent successfully']);
            } catch(Exception $e) {
                return response()->json(['success' => false,'message'=> 'Server did not respond. Please try after sometime.']);
            }
        } else {
            return response()->json(['success' => false,'message'=> 'Unauthorized access']);
        }
    }

    public function adminLoginConfirm(Request $request)
    {
        if(\Auth::check()) {
            $validatedData = $request->validate([
                'admin_login_otp' => 'required|max:6'
            ], [
                'admin_login_otp.required'=>'Please enter otp sent on your email'
            ]);
            $admin_login_otp = $request->admin_login_otp;
            try {
                $otp_sent_at = Auth::user()->otp_sent_at;
                $currentTime = time();
                if( time() > ($otp_sent_at + 180)) {
                    return redirect()->back()->withErrors(['admin_login_otp'=>'OTP has been expired']);
                } elseif(Auth::user()->login_otp == $admin_login_otp) {
                    Auth::user()->login_otp = 0;
                    Auth::user()->otp_sent_at = null;
                    Auth::user()->save();
                    add_admin_logs(Auth::user()->id, 'login', "Admin ". Auth::user()->username." has login successfully");
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->back()->withErrors(['admin_login_otp'=>'Please enter valid OTP']);
                }
            } catch(Exception $e) {
                return redirect()->back()->withErrors(['admin_login_otp'=>'Server did not respond. Please try after sometime.']);
            }
        } else {
            return redirect('/login');
        }
    }

}