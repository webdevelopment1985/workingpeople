<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Currency;
use App\Services\ApiAccessService;
use Log;
use DB;

class ApiController extends Controller
{
    protected $apiAccessService;

    public function __construct(ApiAccessService $apiAccessService)
    {
        $this->apiAccessService = $apiAccessService;
    }

    public function getUserBalances(Request $request)
    {
        $jsonData = $request->json()->all();

        // Validate JSON structure and required fields
        $validator = Validator::make($jsonData, [
            'email' => 'required|email',
            'nonce' => 'required',
            'signature' => 'required',
            'timestamp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msg' => $validator->errors(),
                'code' => 400
            ], 400);
        }

        $email = filter_var($jsonData['email'], FILTER_SANITIZE_EMAIL);
        $currencyName = $jsonData['currency_name'] ?? null;

        $apiInfo = $this->apiAccessService->getApiAccess($jsonData, $request->headers->all(), [$email, $currencyName]);

        if ($apiInfo['res'] && $apiInfo['successmsg'] === 'SUCCESS') {
            // $query = Currency::where('status', 1);
            // if ($currencyName) {
            //     $query->where('symbol', $currencyName);
            // }

            // $currencyData = $query->select(
            //     'id',
            //     'symbol',
            //     'decimal_points',
            //     'type',
            //     'fee_type',
            //     'fees',
            //     'minimum_withdraw',
            //     'max_withdraw',
            //     'daily_transfer_limit'
            // )->get();

            $balanceArray = [];
            $user = $apiInfo['rows'];
            $balanceArray[] = [
                'symbol' => 'USDT',
                'id' => 1,
                'withdrawable_amount' => $user->withdrawable_amount,
                'daily_transfer_limit' => 0,
                'fee_type' => 0,
                'fee' => 0,
                'minimum_withdraw' => 0,
                'max_withdraw' => 0,
            ];
            // foreach ($currencyData as $currency) {
            //     $withdrawableAmount = getUserBalance($apiInfo['rows']->user_id, $currency->id);
            //     $withdrawableAmount = truncate_number($withdrawableAmount, $currency->decimal_points);

            //     $balanceArray[] = [
            //         'symbol' => $currency->symbol,
            //         'id' => $currency->id,
            //         'type' => $currency->type,
            //         'withdrawable_amount' => $withdrawableAmount,
            //         'daily_transfer_limit' => $currency->daily_transfer_limit,
            //         'fee_type' => $currency->fee_type,
            //         'fee' => $currency->fees,
            //         'minimum_withdraw' => $currency->minimum_withdraw,
            //         'max_withdraw' => $currency->max_withdraw,
            //     ];
            // }

            $response = [
                'status' => true,
                'balances' => $balanceArray,
                'code' => 200
            ];
        } else {
            $response = [
                'status' => false,
                'error' => $apiInfo['errormsg'],
                'code' => $apiInfo['code'],
                'data' => $apiInfo
            ];
        }

        Log::info('API Response', $response);
        return response()->json($response, 200);
    }



    public function deductUserBalance(Request $request)
    {

        Log::info('deduct_APIACCESS_response', ["apiResponse" => 1]);

        $jsonData = $request->json()->all();

        $validator = Validator::make($jsonData, [
            'email' => 'required|email',
            'amount' => 'required|numeric',
            'currency_id' => 'required|integer',
            'nonce' => 'required|string',
            'signature' => 'required|string',
            'timestamp' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msg' => $validator->errors(),
                'code' => 400,
            ], 400);
        }

        $email = filter_var($jsonData['email'], FILTER_SANITIZE_EMAIL);
        $currencyId = $jsonData['currency_id'];
        $amount = $jsonData['amount'];
        
        $apiInfo = $this->apiAccessService->getApiAccess($jsonData, $request->headers->all(), [$email, $currencyId, $amount]);
        Log::info('deduct_APIACCESS_response', ["apiResponse" => 1]);

        if (!$apiInfo['res'] || $apiInfo['successmsg'] !== 'SUCCESS') {

            Log::info('deduct_APIACCESS_response', ["apiResponse" => $apiInfo]);

            return response()->json([
                'status' => false,
                'error' => $apiInfo['errormsg'],
                'code' => $apiInfo['code'],
                "data" => $apiInfo
            ]);
        }

        // $userId = $apiInfo['rows']->user_id;
        $wallet = $apiInfo['rows']->withdrawable_amount;

        if (!$wallet) {
            return response()->json([
                'status' => false,
                'message' => 'Wallet not found for the given user and currency.'
            ], 404);
        }

        if ($wallet < $amount) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient balance.'
            ], 400);
        }

        // $today = now()->format('Y-m-d');
        // $dailyWithdrawal = DB::table('withdraw_amount_history')
        //     ->where('user_id', $userId)
        //     ->where('currency_id', $currencyId)
        //     ->whereDate('created', $today)
        //     ->sum('amount');

        $newBalance = $wallet - $amount;
        $user = $apiInfo['rows'];
        $user->withdrawable_amount = $newBalance;
        $user->save();
        $userId = $user->id;
        $txid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $ipAddress = getIp();
        $symbol = 'USDT';

        $withdrawData = [
            'user_id' => $userId,
            'amount' => $amount,
            'previous_amount' => $wallet,
            'new_amount' => $newBalance,
            'status' => 1,
            'currency_id' => 1,
            'txid' => $txid,
            'ip_address' => $ipAddress,
            'naration' => "$amount $symbol deducted successfully from your wallet"
        ];
        $withdrawId = DB::table('withdraw_amount_history')->insertGetId($withdrawData);

        $transactionData = [
            'user_id' => $userId,
            'currency' => 'USDT',
            'narration' => "$amount $symbol transferred into withdraw wallet account",
            'type' => 'debit',
            'trans_type' => 'wallet-transfer',
            // 'value' => $amount,
            'txid' => $txid,
            'fee' => 0,
            'amount' => $amount,
            'created_at' => now(),
            'updated_at' => now(),
            'ip' => $ipAddress,
            'reference_id' => $withdrawId,
            'status' => 0,
        ];
        DB::table('transactions')->insert($transactionData);

        $remarks = "Amount deducted $symbol $amount";
        $type = "wallet-transfer";
        add_user_logs( $userId, $type,$remarks);

        return response()->json([
            'status' => true,
            'message' => 'Amount deducted successfully.',
            'new_balance' => $newBalance,
            "txid" => $txid,
            "reference_id" => $withdrawId
        ]);
    }


    public function withdrawalCallback(Request $request)
    {

        Log::info('withdraw_APIACCESS_response', ["apiResponse" => 22]);
        // Retrieve the raw JSON input
        $rawData = $request->getContent();
        $jsonData = json_decode($rawData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['status' => false, 'msg' => 'Invalid JSON format'], 400);
        }

        // Validate the JSON data
        $validator = Validator::make($jsonData, [
            'email' => 'required|email',
            'amount' => 'required|numeric',
            'hash' => 'required|string',
            'fee' => 'required|numeric',
            'currency_id' => 'required|string',
            'nonce' => 'required|string',
            'signature' => 'required|string',
            'status' => 'required|integer',
            'uniqueId' => 'required|string',
            'timestamp' => 'required|integer',
            'recieverAddress' => 'required|string',
            'transactionId' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msg' => $validator->errors(),
                'code' => 400
            ], 400);
        }

        // Extract data from the validated request
        $data = $validator->validated();
        $status = $data['status'];
        $uniqueId = $data['uniqueId'];
        $txid = $data['transactionId'] ?? null;

        if ($status == 9) {
            return response()->json([
                'status' => true,
                'error' => 'refund transaction',
                'code' => 200
            ]);
        }

        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $currency_id = $data['currency_id'];
        $amount = $data['amount'];
        $hash = $data['hash'];
        $recieverAddress = $data['recieverAddress'];
        $fee = $data['fee'];
        $ValidateData = [$email, $currency_id, $amount, $hash, $txid, $recieverAddress, $fee, $status, $uniqueId];

        $apiInfo = $this->apiAccessService->getApiAccess($data, $request->headers->all(), $ValidateData);

        if ($apiInfo['res'] && $apiInfo['successmsg'] === 'SUCCESS') {
            $user = $apiInfo['rows'];
            $account_id = $user->id;
            $checkUniqueId = DB::table('withdraw_log')
                ->where('user_id',  $user->id)
                ->where('uniqueId', $uniqueId)
                ->tosql();

            if (!$checkUniqueId) {
                return response()->json([
                    'status' => false,
                    'error' => 'uniqueId not found',
                    'code' => 401
                ], 400);
            }

            // $symbol_id = getcurrencyId($data['currency_id']);
            // if ($symbol_id === 0) {
            //     return response()->json([
            //         'status' => false,
            //         'error' => 'Invalid Currency',
            //         'code' => 401
            //     ], 400);
            // }

            $checkTxId = DB::table('transactions')
                ->where('txid', $txid)
                ->where('uniqueId', $uniqueId)
                ->first();
            // print_r($checkTxId);
            // exit;
            if (!$checkTxId) {
                $transactionData = [
                    'user_id' => $account_id,
                    'currency' => $data['currency_id'],
                    'narration' => $data['currency_id'] . ' ' . $data['amount'] . ' Withdraw successfully',
                    'type' => 'debit',
                    'trans_type' => 'withdraw',
                    'fee' => $data['fee'],
                    'amount' => $data['amount'],
                    'txid' => $txid,
                    'status' => $status,
                    'uniqueId' => $uniqueId,
                    'reference_id' => $account_id,
                    'address' => $data['recieverAddress'],
                    'ip' => request()->ip()
                ];

                $insertId = DB::table('transactions')->insertGetId($transactionData);
                if ($insertId) {
                    $withdraw_amount = $data['amount'] - $data['fee'];
                    $withdraw_insertId = DB::table('withdraw')->insertGetId([
                        'w_amount' => $data['amount'],
                        'amount_to_paid' => $withdraw_amount,
                        'user_id' => $account_id,
                        'currency' => $data['currency_id'],
                        'address' => $data['recieverAddress'],
                        'fee' => $data['fee'],
                        'txid' => $txid,
                        'remarks' => $data['hash'],
                        'uniqueId' => $uniqueId,
                        'reference_id'=>$insertId,
                        'status' => $status,
                        'ip_address'=>request()->ip()
                    ]);
                    // dd($withdraw_insertId);
                    if ($withdraw_insertId) {
                        return response()->json([
                            'status' => true,
                            'msg' => 'success2',
                            'code' => 200
                        ]);
                    }else {
                        return response()->json([
                            'status' => true,
                            'msg' => 'Withdraw transation not created',
                            'code' => 200
                        ]);
                    }
                   
                } else {
                    return response()->json([
                        'status' => false,
                        'error' => 'failed',
                        'code' => 401
                    ]);
                }
            } else {

                $check_with = $this->getWithdrawStatus($txid,$account_id);

                if ($check_with) {

                    DB::table('withdraw')
                    ->where('txid', $txid)
                    ->where('uniqueId', $uniqueId)
                    ->where('user_id', $account_id)
                    ->update([
                        'status' => $status,
                        'remarks' => $hash,
                    ]);
        
                    if ($status == 4) {
                        $remarks = "Withdraw amount of " . $currency_id . ' ' . $amount . ' is approved';
                        $type = "Withdraw";
                        add_user_logs( $account_id, $type,$remarks);
                    }
                }


                if ($status == 6) {
                    $refundData = [
                        'user_id' => $account_id,
                        'currency' => $symbol_id,
                        'narration' => $data['currency_id'] . ' ' . $data['amount'] . ' refund successfully',
                        'type' => 'credit',
                        'trans_type' => 'refund',
                        'value' => $data['amount'],
                        'fee' => $data['fee'],
                        'amount' => $data['amount'],
                        'txid' => $txid,
                        'status' => $status,
                        'address' => $data['recieverAddress'],
                        'ip' => request()->ip()
                    ];

                    DB::table('transactions')->insert($refundData);
                }

                return response()->json([
                    'status' => true,
                    'msg' => 'success1',
                    'code' => 200
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'error' => $apiInfo['errormsg'],
                'code' => $apiInfo['code'],
                'data' => $apiInfo
            ]);
        }
    }

    private function getWithdrawStatus($txid, $account_id)
    {
        return DB::table('withdraw')
        ->where('txid', $txid)
        ->where('user_id', $account_id)
        ->exists();
    }

}
