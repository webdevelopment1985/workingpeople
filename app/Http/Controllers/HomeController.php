<?php

namespace App\Http\Controllers;

use App\Helper\CryptoAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Phases;
use App\Models\Invoice;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\Setting;
use App\Models\Packages;

use Log;

class HomeController extends Controller
{
    
    private $cryptoAPI;

    public function __construct()
    {
        $this->cryptoAPI = new CryptoAPI();
    }

    public function index()
    {
        $user = Auth::user();
        $currency = 'usdt';
        $userId = $user->id;

        $referral_link = $user->referralLink();
        $wallet_amount = $user->getBalance($currency);
        $incomeBalance = $user->getBalance('withdrawable_amount');
        $package_min_price = get_settings('package_min_amount');
        
        $total_deposit_usdt = $user->totalDepositByCurrency($currency);
        $total_purchase = $user->totalPurchase();
        $total_roi_income = $user->totalIncome('roi-income');
        $total_level_income = $user->totalIncome('level-income');
        
        $dataForView = [
            'usdBalance'=>truncate_number($wallet_amount,4),
            'incomeBalance'=>truncate_number($incomeBalance,4),
            'package_min_price' => $package_min_price,
            'total_deposit_usdt' => truncate_number($total_deposit_usdt,4),
            'total_purchase' => truncate_number($total_purchase,4),
            'total_roi_income' => truncate_number($total_roi_income,4),
            'total_level_income' => truncate_number($total_level_income,4),
            'referral_link'=>$referral_link
        ];
        return view('templates.home.dashboard', $dataForView);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('templates.home.profile', compact('user'));
    }

    public function update(Request $request)
    {
        
        
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|min:10|max:10',
        ]);
        $user = User::findOrFail(Auth::user()->id); // Assuming $user is passed to the view

        // Update the user's details
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->save(); // Save the updated user
        
        // Log the action
        add_user_logs(Auth::user()->id, 'invest', Auth::user()->username . ' has updated the user information');
        
        // Redirect back with success message
        return redirect()->route('users.edit', $user)->with('success', 'User updated successfully.');
    }

    public function change_password()
    {
        return view('templates.home.change_password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        add_user_logs(Auth::user()->id, 'change_password', Auth::user()->username . ' has changed password');
        return redirect()->route('password.change')->with('success', 'Password changed successfully.');
    }

    public function mulitple_request()
    {
        
    }

    public function updateSetting(Request $request, $status)
    {
    }

    

}