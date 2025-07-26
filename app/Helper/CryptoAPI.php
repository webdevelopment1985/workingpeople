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
            die('Invalid private key !!');
        }
        openssl_sign($inputString, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        openssl_free_key($privateKey);
        return base64_encode($signature);
    }

    public function make_api_call($action, $input)
    {
        switch ($action) {
            case 'send_otp':
                if ($input['Type'] == 9) {
                    $inputString = $input['Type'] . $input['Email'] . $input['Amount'] .  $input['Currency'] . '';
                    $input['Signature'] = $this->getSignature($inputString);
                    $curlPostData = '';
                    $curlPostData .= '{';
                    $curlPostData .= '"Type":"' . $input['Type'] . '",';
                    $curlPostData .= '"Email":"' . $input['Email'] . '",';
                    $curlPostData .= '"Amount":"' . $input['Amount'] . '",';
                    $curlPostData .= '"Currency":"' . $input['Currency'] . '",';
                    $curlPostData .= '"Signature":"' . $input['Signature'] . '"';
                    $curlPostData .= '}';
                    break;
                } else {
                    $inputString = $input['Type'] . $input['Email'] . '';
                    $input['Signature'] = $this->getSignature($inputString);
                    $curlPostData = '';
                    $curlPostData .= '{';
                    $curlPostData .= '"Type":"' . $input['Type'] . '",';
                    $curlPostData .= '"Email":"' . $input['Email'] . '",';
                    $curlPostData .= '"Signature":"' . $input['Signature'] . '"';
                    $curlPostData .= '}';
                    break;
                }

            case 'verify_otp':
                $inputString = $input['Email'] . $input['VerifyCode'];
                $input['Signature'] = $this->getSignature($inputString);
                $curlPostData = '{
                    "Email":"' . $input['Email'] . '",
                    "VerifyCode":"' . $input['VerifyCode'] . '",
                    "UserID":"' . $input['UserID'] . '",
                    "Signature":"' . $input['Signature'] . '"
                }';
                break;
            case 'withdraw_request_link':
                $inputString = $input['Email'] . $input['Currency'] . $input['CallbackURL'] . $input['WebhookURL'] . $input['KycStatus'];
                $input['Signature'] = $this->getSignature($inputString);
                $curlPostData = '{
                        "Email":"' . $input['Email'] . '",
                        "Currency":"' . $input['Currency'] . '",
                        "CallbackURL":"' . $input['CallbackURL'] . '",
                        "WebhookURL":"' . $input['WebhookURL'] . '",
                        "KycStatus":"' . $input['KycStatus'] . '",
                        "CurrencyWalletType":"' . $input['CurrencyWalletType'] . '",
                        "Signature":"' . $input['Signature'] . '"
                    }';
                break;
            case 'RequestConversionTransaction':
                $inputString = $input['Email'] . $input['VerifyCode'] . $input['Amount'] . $input['Currency'];
                $input['Signature'] = $this->getSignature($inputString);
                $curlPostData = '{
                    "Email":"' . $input['Email'] . '",
                    "VerifyCode":"' . $input['VerifyCode'] . '",
                    "Currency":"' . $input['Currency'] . '",
                    "Amount":"' . $input['Amount'] . '",
                    "Signature":"' . $input['Signature'] . '"
                }';
                break;
            case 'withdraw_transactions':
                $inputString = $input['Email'] . $input['Currency'] . $input['TransactionId'] . $input['Hash'] . $input['RecieverAddress'] . $input['Take'] . $input['Skip'];
                $input['Signature'] = $this->getSignature($inputString);
                $curlPostData = '{
                        "Email":"' . $input['Email'] . '",
                        "Currency":"' . $input['Currency'] . '",
                        "TransactionId":"' . $input['TransactionId'] . '",
                        "Hash":"' . $input['Hash'] . '",
                        "RecieverAddress":"' . $input['RecieverAddress'] . '",
                        "Take":"' . $input['Take'] . '",
                        "Skip":"' . $input['Skip'] . '",
                        "SortName":"' . $input['SortName'] . '",
                        "SortOrder":"' . $input['SortOrder'] . '",
                        "Signature":"' . $input['Signature'] . '"
                    }';
                break;
            case 'withdraw_transactions_all':
                $inputString = $input['Email'] . $input['Currency'] . $input['TransactionId'] . $input['Hash'] . $input['RecieverAddress'] . $input['Status'] . $input['Take'] . $input['Skip'] . $input['Token'];
                $input['Signature'] = $this->getSignature($inputString);
                $curlPostData = '{
                        "Email":"' . $input['Email'] . '",
                        "Currency":"' . $input['Currency'] . '",
                        "TransactionId":"' . $input['TransactionId'] . '",
                        "Hash":"' . $input['Hash'] . '",
                        "RecieverAddress":"' . $input['RecieverAddress'] . '",
                        "Take":"' . $input['Take'] . '",
                        "Skip":"' . $input['Skip'] . '",
                        "Token":"' . $input['Token'] . '",
                        "Status":"' . $input['Status'] . '",
                        "SortName":"' . $input['SortName'] . '",
                        "SortOrder":"' . $input['SortOrder'] . '",
                        "Signature":"' . $input['Signature'] . '"
                    }';
                break;
            case 'get_Account':
                $inputString = $input['Email'];
                $input['Signature'] = $this->getSignature($inputString);
                $curlPostData = '{
                    "Email":"' . $input['Email'] . '",
                    "Signature":"' . $input['Signature'] . '"
                }';
                break;
            case 'sync_Transactions':
                $inputString = $input['Email'] . $input['Currency'];
                $input['Signature'] = $this->getSignature($inputString);
                $curlPostData = '{
                    "Email":"' . $input['Email'] . '",
                    "Currency":"' . $input['Currency'] . '",
                    "Signature":"' . $input['Signature'] . '"
                }';
                break;
            case 'withdraw_Request':
                $inputString = $input['Email'] . $input['VerifyCode'] . $input['Address'] . $input['Amount'];
                $input['Signature'] = $this->getSignature($inputString);
                $curlPostData = '{
                    "Email":"' . $input['Email'] . '",
                    "VerifyCode":"' . $input['VerifyCode'] . '",
                    "Address":"' . $input['Address'] . '",
                    "Amount":"' . $input['Amount'] . '",
                    "Signature":"' . $input['Signature'] . '"
                }';
                break;
            case 'usdt_withdraw_Request':
                $inputString = $input['Email'] . $input['VerifyCode'] . $input['Address'] . $input['Amount'];
                $input['Signature'] = $this->getSignature($inputString);
                $curlPostData = '{
                        "Email":"' . $input['Email'] . '",
                        "VerifyCode":"' . $input['VerifyCode'] . '",
                        "Address":"' . $input['Address'] . '",
                        "Amount":"' . $input['Amount'] . '",
                        "Signature":"' . $input['Signature'] . '"
                    }';
                break;
            case 'list_Transactions':
                $inputString = $input['Email'] . $input['Type'] . $input['Take'] . $input['Skip'];
                $input['Signature'] = $this->getSignature($inputString);
                $curlPostData = '{
                    "Email":"' . $input['Email'] . '",
                    "Type":"' . $input['Type'] . '",
                    "Take":"' . $input['Take'] . '",
                    "Skip":"' . $input['Skip'] . '",
                    "Signature":"' . $input['Signature'] . '"
                }';
                break;
            case 'buy_srix_Request':
                $inputString = $input['Email'] . $input['VerifyCode'] . $input['Address'] . $input['Amount'] . $input['Rate'];
                $input['Signature'] = $this->getSignature($inputString);
                $curlPostData = '{
                        "Email":"' . $input['Email'] . '",
                        "Type":"' . $input['Type'] . '",
                        "VerifyCode":"' . $input['VerifyCode'] . '",
                        "Address":"' . $input['Address'] . '",                        
                        "Amount":"' . $input['Amount'] . '",
                        "Rate":"' . $input['Rate'] . '",
                        "Signature":"' . $input['Signature'] . '"
                    }';
                break;
            case 'get_Balance':
            case 'sync_UTransactions':
            default:
                $inputString = $input['Email'];
                $input['Signature'] = $this->getSignature($inputString);
                $curlPostData = '{
                    "Email":"' . $input['Email'] . '",
                    "Signature":"' . $input['Signature'] . '"
                }';
                break;
        }
        $endPoint = $this->__actionList[$action];
        $url = $this->__BASE_PATH . $endPoint;
        return $this->custom_curl_request($url, $curlPostData);
    }

    public function custom_curl_request($baseUrl, $curlPostData)
    {

        $httpHeader = array(
            'Authorization: Basic ' . env('CRYPTO_AUTH_KEY'),
            'secret-key: ' . env('CRYPTO_SECRET_KEY'),
            'Content-Type: application/json'
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $baseUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $curlPostData,
            CURLOPT_HTTPHEADER => $httpHeader,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}
