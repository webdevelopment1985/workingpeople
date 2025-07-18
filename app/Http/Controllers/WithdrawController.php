<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRequests;
use App\Models\Deposit;
use App\Models\Withdraw;
use App\Models\Swap;
use App\Models\Phases;
use App\Models\Transaction;
use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Helper\CryptoAPI;
use Validator;
use Log;
use Session;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class WithdrawController extends Controller
{

    private $crypto;

    public function __construct()
    {
        $this->crypto = new CryptoAPI();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dataForView = array();
        $user = Auth::user();
        $currency = 'usdt';
        $userId = $user->id;        

        $dataForView['title'] = 'Withdraw USDT';
        $dataForView['wallet_amount'] = $user->getBalance('usdt');
        $dataForView['withdrawable_amount'] = $user->getWithdrawBalance();
        if ($dataForView['withdrawable_amount'] == 0) {
            //return redirect()->route('user.walletTransfer');
        }
        $dataForView['minimum_withdraw'] = get_settings('minimum_withdraw');
        $dataForView['withdraw_fee'] = get_settings('withdraw_fee');

        return view('templates.user.withdraw', $dataForView);
    }
    


    public function generateWithdrawRequest(Request $request){
        //return response()->json(['R' => false, 'M' => 'Withdraw is temporarily disabled']);
        if (!$request->ajax()) {
            return response()->json(['R' => false, 'M' => 'Invalid request !!']);
        }
        if(\Auth::check()) {

            $user = auth()->user();
            if ($user->getWithdrawBalance() < 1) {
                return response()->json(['R' => false, 'M' => 'Insufficient funds to withdraw !!']);
            }

            
            $email = $user->email;
            $currency_code ='USDT';
            $KycStatus = 1;
            $currency_type = "BEP20";
            $backURL = url('withdraw-response');
            $CallbackURL = url('/v3/withdrawal-callback');
            // dd($backURL,$CallbackURL);
            $response = $this->crypto->make_api_call('withdraw_request_link', [
                'Email' => $email,
                'Currency' => $currency_code,
                'CallbackURL' => $backURL,
                'WebhookURL' => $CallbackURL,
                'KycStatus' => $KycStatus,
                'CurrencyWalletType' => $currency_type,
            ]);
            Log::info('DOTAPI Response', [$response]);
                $withdrawLink = $response;
               
                if (!empty($withdrawLink->status) && $withdrawLink->status === true) {
                    $ip = getIp();
                    $agent = request()->header('User-Agent');
            
                    if (!empty($withdrawLink->uniqueId)) {
                        try {
                            DB::table('withdraw_log')->insert([
                                'ip' => $ip,
                                'user_id' => $user->id, // Set this based on your logic
                                'uniqueId' => $withdrawLink->uniqueId,
                                'agent' => $agent,
                                'created_at' => now(),
                            ]);
            
                            return response()->json(['R' => true, 'M' => 'Successfully generated', 'withdraw_link'=>$withdrawLink->url]);

                        } catch (\Exception $e) {
                            return response()->json(['R' => false, 'M' => $e->getMessage()]);

                        }
                    } else {
                        return response()->json(['R' => false, 'M' => 'Something went wrong, Please try again later']);

                    }
                } else {
                    return response()->json(['R' => false, 'M' => $withdrawLink->details]);

                }
        }
    }



    public function withdrawrequest(Request $request)
    {
        $user = Auth::user();
        $currency = 'usdt';
        $userId = $user->id;

        if (!$request->ajax()) {
            return response()->json(['R' => false, 'M' => 'Invalid request !!']);
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'address' => 'required',
            'type' => 'required|in:1,2',
        ], [
            'amount.required' => 'The amount field is mandatory.',
            'amount.numeric' => 'The amount must be a number.',
            'address.required' => 'The address field is mandatory.',
            'type.required' => 'Invalid withdrawal request',
            'type.in' => 'The type must be either 1 or 2.',
        ]);

        $validator->sometimes('otp', 'required', fn($input) => $input->type == 2);
        $validator->sometimes('request_id', 'required', fn($input) => $input->type == 2);

        if ($validator->fails()) {
            return response()->json(['R' => false, 'M' => $validator->errors()->all()]);
        }

        $walletAmount = $user->getBalance('usdt');
        $withdrawableBalance = $user->getBalance('withdrawable_amount');

        $minWithdraw = get_settings('minimum_withdraw');
        $withdrawFee = get_settings('withdraw_fee');
        $withdrawAmount = $request->amount;

        if ($withdrawAmount < $minWithdraw) {
            return response()->json(['R' => false, 'M' => 'Please enter minimum withdraw amount !!']);
        } elseif ($withdrawAmount > $withdrawableBalance) {
            return response()->json(['R' => false, 'M' => 'You have insufficient balance for withdraw request !!']);
        }

        $withdrawFeeAmount = ($withdrawAmount * ($withdrawFee / 100));
        $actualWithdrawAmount = $withdrawAmount - $withdrawFeeAmount;

        if ($request->type == 1) {
            return $this->handleInitialWithdrawRequest($user, $withdrawAmount, $withdrawFee, $actualWithdrawAmount, $request->address, $request);
        } elseif ($request->type == 2) {
            return $this->handleConfirmWithdrawRequest($user, $withdrawAmount, $request->otp, $request->request_id, $request);
        } else {
            return response()->json(['R' => false, 'M' => 'Invalid request !!']);
        }
    }

    private function handleInitialWithdrawRequest($user, $withdrawAmount, $withdrawFee, $actualWithdrawAmount, $address, $request)
    {
        $otp = random_int(100000, 999999);
        $confirm_key = uniqid() . Str::random(10);
        
        $userRequest = new UserRequests();
        $userRequest->user_id = $user->id;
        $userRequest->type = 'withdraw';
        
        $otp_expire_at = date('Y-m-d H:i:s', strtotime(Carbon::now()->addMinutes(3)));
        $userRequest->meta_data = json_encode([
            'w_amount' => $withdrawAmount,
            'fee' => $withdrawFee,
            'actual_amount' => $actualWithdrawAmount,
            'address' => encrypt_decrypt($address, 'encrypt'),
            'otp' => $otp,
            'otp_expire_at' => $otp_expire_at,
        ]);
        $userRequest->confirm_key = $confirm_key;
        $userRequest->status = 0;
        $userRequest->ip_address = request()->ip();
        $userRequest->created_on = now();
        $userRequest->expire_time = date('Y-m-d H:i:s', strtotime(Carbon::now()->addMinutes(30)));

        if ($userRequest->save()) {
            add_user_logs(Auth::user()->id, 'withdraw', Auth::user()->username . ' has initiated withdraw of amount : ' . $withdrawAmount);

            Mail::send('templates.emails.withdrawconfirmation', [
                'username'=>$user->username,
                'otp' => $otp,
                'address' => $address,
                'amount' =>$withdrawAmount,
                'currency' => 'USDT',
                'otp_valid_mins' => $otp_expire_at,
            ], function ($message) use ($request) {
                $message->to(Auth::user()->email);
                $message->subject('Withdraw confirmation');
            });
            return response()->json(['R' => true, 'M' => 'OTP sent successfully', 'data' => $confirm_key]);
        }
        return response()->json(['R' => false, 'M' => 'Failed to create withdrawal request']);
    }

    private function handleConfirmWithdrawRequest($user, $withdrawAmount, $otp, $confirmKey, $request)
    {
        $pendingRequest = UserRequests::where('confirm_key', $confirmKey)->where('status', 0)->first();

        if (!$pendingRequest) {
            return response()->json(['R' => false, 'M' => 'Invalid withdraw request']);
        }

        $metaData = json_decode($pendingRequest->meta_data, true);
        $currentDateTime = date('Y-m-d H:i:s', strtotime(Carbon::now()));

        if ($metaData['otp'] != $otp) {
            return response()->json(['R' => false, 'M' => 'Invalid OTP']);
        } elseif ($metaData['otp_expire_at'] < $currentDateTime) {
            return response()->json(['R' => false, 'M' => 'OTP has been expired']);
        } elseif ($metaData['w_amount'] != $withdrawAmount) {
            return response()->json(['R' => false, 'M' => 'Withdraw and requested amount does not match']);
        }

        $withdraw = new Withdraw();
        $withdraw->user_id = $user->id;
        $withdraw->currency = 'USDT';
        $withdraw->reference_id = $pendingRequest->id;
        $withdraw->w_amount = $metaData['w_amount'];
        $withdraw->fee = $metaData['fee'];
        $withdraw->amount_to_paid = $metaData['actual_amount'];
        $withdraw->address = $metaData['address'];
        $withdraw->status = 0;
        $withdraw->ip_address = request()->ip();
        $withdraw->user_verify = 1;
        $withdraw->created_at = now();
        $withdraw->updated_at = now();


        if (!$withdraw->save()) {
            return response()->json(['R' => false, 'M' => 'Withdraw not accepted']);
        }

        $pendingRequest->status = 1;
        $pendingRequest->confirm_key = null;
        $pendingRequest->save();

        $transaction = (new Transaction())->updateUserBalance($user->id, $withdrawAmount, $metaData['fee'], 'USDT', 'USDT withdraw successfully done', 'debit', 'withdraw', 1, $withdraw->id, null);
        if ($transaction) {
            add_user_logs(Auth::user()->id, 'withdraw', Auth::user()->username . ' has confirmed withdraw of amount : ' . $withdrawAmount);
            Mail::send('templates.emails.withdrawconfirmed', [
                'username'=>$user->username,
                'address' => encrypt_decrypt($metaData['address'], 'decrypt'),
                'amount' =>$metaData['w_amount'],
                'currency' => 'USDT',
            ], function ($message) use ($request) {
                $message->to(Auth::user()->email);
                $message->subject('Withdraw confirmed successfully');
            });
            $user->refresh();
            return response()->json(['R' => true, 'M' => "Withdraw confirmed successfully", 'data' => ['withdrawable_amount' => $user->withdrawable_amount]]);
        }
        return response()->json(['R' => false, 'M' => 'Wallet balance deduction failed']);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $users)
    {
        //
    }


    public function transactions(Request $request)
    {
        $dataForView = array();
        $dataForView['title'] = 'Transactions';       
        return view('templates.user.transactions', $dataForView);
    }

    public function getWithdrawHistory(Request $request)
    {
        $columns = array(
            0 =>'created_at',
            1=> 'w_amount',
            2=> 'fee',
            3=> 'amount_to_paid',
            4=> 'status'
        );
 
        $user = auth()->user();

        $limit = $request->input('length');
        $start = $request->input('start');
        
        $totalData = Withdraw::where('user_id', $user->id)->count();
        $totalFiltered = $totalData;
        
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
 
        if(!empty($request->input('search.value'))) {

            $search = $request->input('search.value'); 
            $transactions =  Withdraw::where('currency', "%{$search}%")
                ->orWhere('w_amount', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhere('amount_to_paid', 'LIKE', "%{$search}%")
                ->orWhere('txid', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
 
            $totalFiltered = Withdraw::where('w_amount', 'LIKE', "%{$search}%")
            ->orWhere('w_amount', 'LIKE', "%{$search}%")
            ->orWhere('status', 'LIKE', "%{$search}%")
            ->orWhere('amount_to_paid', 'LIKE', "%{$search}%")
            ->orWhere('txid', 'LIKE', "%{$search}%")
            ->count();

           
        } else {
            $transactions = Withdraw::offset($start)
            ->where('user_id', $user->id)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
            // print_r($transactions);die;
        }
        $data = array();
        $srNo = 1;
                                 
        if(!empty($transactions)) {
            foreach ($transactions as $transaction) {
                $alink = "https://bscscan.com/tx/" . $transaction->remarks;  
                $nestedData = array();
                $nestedData[] = $srNo++;
                $nestedData[] = date('Y-m-d H:i:s', strtotime($transaction->created_at));
                $nestedData[] = truncate_number($transaction->w_amount,4);
                $nestedData[] = truncate_number($transaction->fee,4);
                $nestedData[] = truncate_number($transaction->amount_to_paid,4);
                $nestedData[] = $transaction->remarks ? "<a href={$alink} target='_blank'>" . showHash($transaction->remarks) . "</a>" : "-";
                
                if($transaction->status == 4){
                    $nestedData[] = 'Approved';
                }
                else if($transaction->status == 6){
                    $nestedData[] = 'Rejected';
                }
                else if($transaction->status == 12){
                    $nestedData[] = 'Pending';
                }
                else{
                    $nestedData[] = 'Processing';
                }
                $data[] = $nestedData;
            }
        }
 
        $json_data = array(
        "draw"            => intval($request->input('draw')),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $data
        );
 
        return response()->json($json_data);
    }
    

/*
    public function getWithdrawHistory(Request $request)
    {
        $columns = array(
            0 =>'created_at',
            1=> 'w_amount',
            2=> 'fee',
            3=> 'amount_to_paid',
            4=> 'status'
        );
 
        $user = auth()->user();

        $limit = $request->input('length');
        $start = $request->input('start');
        
        $totalData = Withdraw::where('user_id', $user->id)->count();
        $totalFiltered = $totalData;
        
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
 
        if(!empty($request->input('search.value'))) {

            $search = $request->input('search.value'); 
            $transactions =  Withdraw::where('currency', "%{$search}%")
                ->orWhere('w_amount', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhere('amount_to_paid', 'LIKE', "%{$search}%")
                ->orWhere('txid', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
 
            $totalFiltered = Withdraw::where('w_amount', 'LIKE', "%{$search}%")
            ->orWhere('w_amount', 'LIKE', "%{$search}%")
            ->orWhere('status', 'LIKE', "%{$search}%")
            ->orWhere('amount_to_paid', 'LIKE', "%{$search}%")
            ->orWhere('txid', 'LIKE', "%{$search}%")
            ->count();

           
        } else {
            $transactions = Withdraw::offset($start)
            ->where('user_id', $user->id)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
            // print_r($transactions);die;
        }
        $data = array();
        $srNo = 1;
                                                    
        if(!empty($transactions)) {
            foreach ($transactions as $transaction) {
                $nestedData = array();
                $nestedData[] = $srNo++;
                $nestedData[] = date('Y-m-d H:i:s', strtotime($transaction->created_at));
                $nestedData[] = truncate_number($transaction->w_amount,4);
                $nestedData[] = truncate_number($transaction->fee,4);
                $nestedData[] = truncate_number($transaction->amount_to_paid,4);
                $nestedData[] = ($transaction->status == 1) ? $transaction->txid : '-';
                if($transaction->status == 1){
                    $nestedData[] = 'Approved';
                }
                else if($transaction->status == 2){
                    $nestedData[] = 'Rejected';
                }
                else if($transaction->status == 3){
                    $nestedData[] = 'Cancelled';
                }
                else{
                    $nestedData[] = 'Pending';
                }
                
                $data[] = $nestedData;
            }
        }
 
        $json_data = array(
        "draw"            => intval($request->input('draw')),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $data
        );
 
        return response()->json($json_data);
    }
    
*/
    public function withdrawResponse(Request $request,$currency,$status){

        if ($status == 1) {
            Session::flash('success', 'Your Withdraw Request Successfully Processing.');
        }elseif ($status == 2) {
            Session::flash('error', 'Your Withdraw Request is failed.');
        }elseif ($status == 3) {
            Session::flash('error', 'Your Withdraw Request is cancelled.');
        }else {
            Session::flash('error', 'Something went wrong, Please try again later.');
        }
       return redirect()->route('user.withdraw');
    }

}
