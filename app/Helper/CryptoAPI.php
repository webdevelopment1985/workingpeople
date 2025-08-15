<?php

namespace App\Helper;

use Log;

class CryptoAPI
{

    private $__BASE_PATH;

    private $__privateKeyString;

    private $__Authorization;

    private $__secretKey;

    private $__contentType;

    private $__actionList = array();

    public function __construct()
    {
        $this->__BASE_PATH = env('CRYPTO_BASE_PATH');


        $this->__actionList = array(
            'send_otp' => '/api/RequestAccount',
            'verify_otp' => '/api/RequestAccountVerify',
            'get_Account' => '/api/AccountGet',
            'get_Balance' => '/api/BalanceGet',
            'sync_Transactions' => '/api/SyncTransaction',
            'sync_UTransactions' => '/api/SyncUToken',
            'list_Transactions' => '/api/TransactionListGet',
            'sync_swap_Transactions' => '/api/TransactionDetailsGet',
            'withdraw_Request' => '/api/RequestWithdrawal',
            'request_Old_Coin_Swap' => '/api/RequestOldCoinSwap',
            'buy_srix_Request' => '/api/RequestUSDTSRIXSwap',
            'usdt_withdraw_Request' => '/api/RequestUSDTSwap',
            'sync_Old_Transactions' => '/api/SyncOldTransaction',
            'admin_Request_Old_Swap' => '/api/RequestAdminOLdSwap',
            'withdraw_request_link' => '/api/RequestWithdrawalLink',
            'RequestConversionTransaction' => '/api/RequestConversionTransaction',
            'withdraw_transactions_all' => '/api/WithdrawalListGetAdminAll',
            'withdraw_transactions' => '/api/WithdrawalListGetAdmin',
        );
        $this->__privateKeyString = '';
    }

    public function getHeaders()
    {
        $authKey = env('CRYPTO_AUTH_KEY');
        $secretKey = env('CRYPTO_SECRET_KEY');
        return array(
            'Authorization: Basic ' . $authKey,
            'secret-key: ' . $secretKey,
            'Content-Type: application/json'
        );
    }

    private function getSignature($inputString)
    {
        $privateKey = openssl_pkey_get_private($this->__privateKeyString);
        if ($privateKey === false) {
        }
        return '';
    }

    public function make_api_call($action, $input)
    {
        return (object)[
            'message' => 'success',
            'usdtAddress' => '0x1234567890abcdef1234567890abcdef12345678',
            'wBalance' => [
                (object)[
                    'currrency' => 'USDT',
                    'balance' => 0
                ]
            ],
            'transactions' => []
        ];
    }

    public function custom_curl_request($baseUrl, $curlPostData)
    {
        // $httpHeader = array(
        //     'Authorization: Basic ' . env('CRYPTO_AUTH_KEY'),
        //     'secret-key: ' . env('CRYPTO_SECRET_KEY'),
        //     'Content-Type: application/json'
        // );

        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => $baseUrl,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => $curlPostData,
        //     CURLOPT_HTTPHEADER => $httpHeader,
        // ));
        // $response = curl_exec($curl);
        // curl_close($curl);
        // return json_decode($response);
    }
}
