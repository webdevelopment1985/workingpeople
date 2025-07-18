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

class TestController extends Controller
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
            'usdBalance' => truncate_number($wallet_amount, 4),
            'incomeBalance' => truncate_number($incomeBalance, 4),
            'package_min_price' => $package_min_price,
            'total_deposit_usdt' => truncate_number($total_deposit_usdt, 4),
            'total_purchase' => truncate_number($total_purchase, 4),
            'total_roi_income' => truncate_number($total_roi_income, 4),
            'total_level_income' => truncate_number($total_level_income, 4),
            'referral_link' => $referral_link
        ];
        
        return view('templates.home.dashboard', $dataForView);
    }


    public function depositAddress(Request $request)
    {
        $email = $request->query('email');
        $CryptoAPI = new CryptoAPI();
        $responseAccnt = $CryptoAPI->make_api_call('get_Account', [
            "Email" => $email,
            "Currency" => "USDT"
        ]);
        print_r($responseAccnt);
        die;
    }


    public function getBalance(Request $request)
    {
        $email = $request->query('email');
        $CryptoAPI = new CryptoAPI();
        $responseAccnt = $CryptoAPI->make_api_call('get_Balance', [
            "Email" => $email
        ]);
        print_r($responseAccnt);
        die;
    }




}