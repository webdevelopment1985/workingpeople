<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Transaction;
use App\Models\InternalTransfer;
use App\Models\WalletTransfer;
use App\Models\UserRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Validator;
use DB;
use Log;
use Mail;
use App\Helper\CryptoAPI;

class TransferController extends Controller
{

    private $crypto;

    public function __construct()
    {
        $this->crypto = new CryptoAPI();
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {}


    public function internalTransfer(Request $request)
    {
        $dataForView = array();
        $user = Auth::user();
        $currency = 'usdt';
        $userId = $user->id;

        $dataForView['title'] = 'Internal Transfer';

        $wallet_amount = $user->getBalance('usdt');
        $dataForView['wallet_amount'] = $wallet_amount;

        $min_Transfer_Amount = get_settings('min_internal_transfer');
        $dataForView['min_internal_transfer'] = $min_Transfer_Amount;

        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', Rule::exists('users', 'email')->where('users_type', 1)->where('is_verified', 1)],
                'amount' => ['required', 'numeric', 'min:' . $min_Transfer_Amount],
                'type' => 'required|in:1,2',
            ], [
                'email.required' => 'Email address is mandatory.',
                'email.email' => 'Please enter a valid email address.',
                'email.exists' => 'User does not exist or inactive in our records.',
                'amount.required' => 'Please enter a valid amount.',
                'amount.numeric' => 'Amount must be a valid number.',
                'amount.min' => 'The amount must be at least ' . $min_Transfer_Amount . '.',
                'type.required' => 'Invalid transfer request.',
                'type.in' => 'The type must be either 1 or 2.',
            ]);

            $validator->sometimes('otp', 'required', fn($input) => $input->type == 2);
            $validator->sometimes('request_id', 'required', fn($input) => $input->type == 2);

            if ($validator->fails()) {
                return response()->json(['R' => false, 'M' => $validator->errors()->all()]);
            }

            $email = $request->email;
            $otp = $request->otp;
            $amount = $request->amount;

            if ($amount < $min_Transfer_Amount) {
                return $this->sendresponse(false, 'Please enter minimum transfer amount.');
            } elseif ($amount > $wallet_amount) {
                return $this->sendresponse(false, 'You have insufficient balance for transfer request.');
            }

            $to_user = User::where('email', $email)->first();
            if ($request->type == 1) {
                if (!$to_user->is_verified) {
                    return $this->sendresponse(false, 'User has not verified his account.');
                }
                $myDownlineUsers = $this->getDownlineUsers($userId);
                if (!in_array($to_user->id, $myDownlineUsers)) {
                    return $this->sendresponse(false, 'You can transfer only to your downline user.');
                }
                return $this->handleInitialTransferRequest($to_user, $amount, $email, $request);
            } elseif ($request->type == 2) {
                return $this->handleConfirmTransferRequest($to_user, $amount, $email, $otp, $request->request_id, $request);
            } else {
                return $this->sendresponse(false, 'Invalid transfer request.');
            }
        }
        return view('templates.user.internalTransfer', $dataForView);
    }

    private function handleInitialTransferRequest($to_user, $amount, $email, $request)
    {
        $otp = random_int(100000, 999999);
        $confirm_key = uniqid() . Str::random(10);

        $internalTransfer = new InternalTransfer();
        $internalTransfer->transactionId = 'TX-' . Str::random(5) . uniqid() . Str::random(5);
        $internalTransfer->from_user = Auth::user()->id;
        $internalTransfer->to_user = $to_user->id;
        $internalTransfer->amount = $amount;
        $internalTransfer->confirm_key = $confirm_key;
        $internalTransfer->ip_address = request()->ip();
        $internalTransfer->status = 0;
        $internalTransfer->otp = $otp;
        $internalTransfer->otp_expire_time =  date('Y-m-d H:i:s', strtotime(Carbon::now()->addMinutes(3)));
        $internalTransfer->created_at = date('Y-m-d H:i:s', strtotime(Carbon::now()));

        if ($internalTransfer->save()) {
            Mail::send('templates.emails.transferconfirmation', [
                'username' => Auth::user()->username,
                'otp' => $otp,
                'amount' => $amount,
                'currency' => 'USDT',
                'otp_valid_mins' => 3,
            ], function ($message) use ($request) {
                $message->to(Auth::user()->email);
                $message->subject('Internal Transfer Confirmation');
            });
            add_user_logs(Auth::user()->id, 'internal-transfer', Auth::user()->username . ' has initiated internal transfer of amount : ' . $amount);
            $logData = [
                'request' => $request,
                'from_user' => Auth::user()->username,
                'to_user' => $to_user->username
            ];
            \Log::info('internalTransfer:init[' . Auth::user()->email . ']' . json_encode($logData));
            return $this->sendresponse(true, 'OTP sent successfully.', $confirm_key);
        }
        return $this->sendresponse(false, 'Failed to create transfer request.');
    }

    private function handleConfirmTransferRequest($to_user, $amount, $email, $otp, $confirmKey, $request)
    {
        $pendingTransfer = InternalTransfer::where('confirm_key', $confirmKey)->where('from_user', Auth::user()->id)->where('status', 0)->first();

        if (!$pendingTransfer) {
            return $this->sendresponse(false, 'There is no pending transfer request.');
        }

        $metaData = json_decode($pendingTransfer->meta_data, true);
        $currentDateTime = date('Y-m-d H:i:s', strtotime(Carbon::now()));

        // Validate OTP and transfer amount
        if ($pendingTransfer->otp != $otp) {
            return $this->sendresponse(false, 'Invalid OTP');
        }

        if ($pendingTransfer->otp_expire_time < $currentDateTime) {
            return $this->sendresponse(false, 'OTP has expired');
        }
        if ($pendingTransfer->amount != $amount) {
            return $this->sendresponse(false, 'Please check your requested transfer amount.');
        }

        $pendingTransfer->update(['status' => 1, 'confirm_key' => null, 'otp' => 0, 'otp_expire_at' => null]);

        // Handle user balance updates in a transaction
        DB::transaction(function () use ($to_user, $amount, $pendingTransfer) {
            (new Transaction())->updateUserBalance($to_user->id, $amount, 0, 'USDT', 'USDT received', 'credit', 'internal-transfer', 1, $pendingTransfer->id, null);
            (new Transaction())->updateUserBalance(Auth::user()->id, $amount, 0, 'USDT', 'USDT sent', 'debit', 'internal-transfer', 1, $pendingTransfer->id, null);
        });


        Mail::send('templates.emails.transferconfirmed', [
            'username' => $to_user->username,
            'amount' => $amount,
            'currency' => 'USDT',
        ], function ($message) {
            $message->to(Auth::user()->email);
            $message->subject('Transfer Confirmed Successfully');
        });

        $authUser = Auth::user();
        $authUser->refresh(); // Refresh auth user to get updated data

        add_user_logs(Auth::user()->id, 'internal-transfer', Auth::user()->username . ' has confirmed transfer of amount : ' . $amount);
        $logData = [
            'request' => $request,
            'from_user' => Auth::user()->username,
            'to_user' => $to_user->username
        ];
        \Log::info('internalTransfer:confirm[' . Auth::user()->email . ']' . json_encode($logData));
        return $this->sendresponse(true, 'Transfer confirmed successfully', ['wallet_amount' => $authUser->wallet_amount]);
    }


    public function internalTransferHistory(Request $request)
    {
        $columns = array(
            0 => 'created_at',
            1 => 'created_at',
            2 => 'transactionId',
            3 => 'from_user',
            4 => 'amount',
            5 => 'created_at',
            6 => 'status'
        );

        $user = auth()->user();
        $fromUserId = $toUserId = $user->id;

        $limit = $request->input('length');
        $start = $request->input('start');

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (!empty($request->input('search.value'))) {
            $transactionsQuery = InternalTransfer::where(function ($query) use ($fromUserId, $toUserId) {
                $query->where('from_user', $fromUserId)
                    ->orWhere('to_user', $toUserId);
            })
                ->when(request()->input('search.value'), function ($query) {
                    $query->whereHas('fromUser', function ($q) {
                        $q->where('username', 'like', '%' . request()->input('search.value') . '%');
                    })
                        ->orWhereHas('toUser', function ($q) {
                            $q->where('username', 'like', '%' . request()->input('search.value') . '%');
                        });
                })
                ->where('status', 1)
                ->with(['fromUser', 'toUser'])
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir);

            $transactions = $transactionsQuery->get();
            $totalFiltered = $totalData = $transactionsQuery->count();
        } else {

            $transactionsQuery = InternalTransfer::where(function ($query) use ($fromUserId, $toUserId) {
                $query->where('from_user', $fromUserId)
                    ->orWhere('to_user', $toUserId);
            })
                ->where('status', 1)
                ->with(['fromUser', 'toUser'])
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir);

            $transactions = $transactionsQuery->get();
            $totalFiltered = $totalData = $transactionsQuery->count();
        }
        $data = array();
        $srNo = 1;

        if (!empty($transactions)) {
            foreach ($transactions as $transaction) {

                $is_Sender = $transaction->fromUser->id == $user->id ? 1 : 0;
                $nestedData = array();
                $nestedData[] = $srNo++;
                $nestedData[] = date('Y-m-d H:i:s', strtotime($transaction->created_at));
                $nestedData[] = $transaction->transactionId;
                if ($is_Sender) {
                    $nestedData[] = $transaction->toUser->username;
                } else {
                    $nestedData[] = $transaction->fromUser->username;
                }
                $nestedData[] = truncate_number($transaction->amount, 4);
                $nestedData[] = $is_Sender ? 'Sent' : 'Received';

                if ($transaction->status == 1) {
                    $nestedData[] = 'Completed';
                } else if ($transaction->status == 2) {
                    $nestedData[] = 'Rejected';
                } else if ($transaction->status == 3) {
                    $nestedData[] = 'Cancelled';
                } else {
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


    /** walletTransfer **/

    public function walletTransfer(Request $request)
    {
        $dataForView = array();
        $user = Auth::user();
        $userId = $user->id;

        $dataForView['title'] = 'Wallet Transfer';

        $wallet_amount = $user->getBalance('withdrawable_amount');
        $withdrawal_amount = $user->getWithdrawBalance();
        $dataForView['wallet_amount'] = $wallet_amount;
        $dataForView['withdrawal_amount'] = $withdrawal_amount;


        if ($request->ajax()) {
            $min_Transfer_Amount = 1;
            $validator = Validator::make($request->all(), [
                'amount' => ['required', 'numeric', 'min:' . $min_Transfer_Amount],
                'type' => 'required|in:1,2',
            ], [
                'amount.required' => 'Please enter a valid amount.',
                'amount.numeric' => 'Amount must be a valid number.',
                'amount.min' => 'The amount must be at least ' . $min_Transfer_Amount . '.',
            ]);

            $validator->sometimes('otp', 'required', fn($input) => $input->type == 2);
            // $validator->sometimes('request_id', 'required', fn($input) => $input->type == 2);

            if ($validator->fails()) {
                return response()->json(['status' => "error", 'msg' => $validator->errors()->first()]);
            }

            $email = auth()->user()->email;
            $otp = $request->otp;
            $amount = $request->amount;

            if ($amount < $min_Transfer_Amount) {
                return response()->json(['status' => "error", 'msg' => 'Please enter minimum transfer amount.']);
            } elseif ($amount > $wallet_amount) {
                return response()->json(['status' => "error", 'msg' => 'You have insufficient balance for transfer request.']);
            }
            $symbol = 'USDT';
            if ($request->type == 1) {
                return $this->sendOtp($email, $symbol, $amount);
            } elseif ($request->type == 2) {
                $authCode = $request->input('otp');
                return $this->verifyOtp($email, $authCode, $symbol, $amount);
            } else {
                return response()->json(['status' => "error", 'msg' => 'Invalid Transfer Request.']);
            }
        }
        return view('templates.user.walletTransfer', $dataForView);
    }

    private function sendOtp($email, $symbol, $amountW)
    {
        Log::info('transfer_SendOTP_request', [
            "Type" => 9,
            "Email" => $email,
            "Currency" => $symbol,
            "Amount" => $amountW
        ]);

        $apiResponse = $this->crypto->make_api_call('send_otp', [
            "Type" => 9,
            "Email" => $email,
            "Currency" => strtoupper($symbol),
            "Amount" => $amountW
        ]);

        Log::info('transfer_SendOTP_response', ["apiResponse" => $apiResponse]);

        if ($apiResponse->message === 'success' && isset($apiResponse->details)) {
            return response()->json([
                'status' => 'success',
                'msg' => $apiResponse->details,
                'data' => $apiResponse
            ]);
        }

        return response()->json([
            'status' => 'error',
            'msg' => $apiResponse->details ?? 'Error occurred',
            'data' => $apiResponse
        ]);
    }

    private function verifyOtp($email, $authCode, $symbol, $amountW)
    {
        Log::info('transfer_VerifyOTP_request', [
            "Email" => $email,
            "VerifyCode" => $authCode,
            "Currency" => $symbol,
            "Amount" => $amountW
        ]);

        $apiResponse = $this->crypto->make_api_call('RequestConversionTransaction', [
            "Email" => $email,
            "VerifyCode" => $authCode,
            "Currency" => strtoupper($symbol),
            "Amount" => $amountW
        ]);

        Log::info('transfer_VerifyOTP_response', ["apiResponse" => $apiResponse]);

        $user = auth()->user();
        $accountId = $user->id;
        if ($apiResponse->message === 'success') {

            WalletTransfer::where('txid', $apiResponse->referenceNo)->update([
                'status' => 1,
                'txn_hash' => $apiResponse->uniqueTransactionId
            ]);

            Transaction::where(['txid' => "$apiResponse->referenceNo", 'type' => 'wallet-transfer', 'user_id' => $accountId])->update(['status' => 1]);

            add_user_logs($accountId, "wallet-transfer", "wallet_transfer verified of amount {$amountW} {$symbol}");
            $refreshuser = auth()->user()->refresh();
            $wallet_amount = $refreshuser->getBalance('withdrawable_amount');
            $withdrawal_amount = $refreshuser->getWithdrawBalance();
            return response()->json([
                'status' => 'success',
                'msg' => 'Wallet Transfer Successfully',
                'data' => $apiResponse,
                'wallet_amount' => $wallet_amount,
                'withdraw_amount' => $withdrawal_amount
            ]);
        }

        add_user_logs($accountId, "wallet-transfer", "wallet_transfer crypto failed " . json_encode($apiResponse));

        return response()->json([
            'status' => 'error',
            'msg' => $apiResponse->details ?? 'Server did not respond. Please try again later.',
            'data' => $apiResponse
        ]);
    }

    public function walletTransferHistory(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'created_at',
            2 => 'txid',
            3 => 'narration',
            4 => 'amount',
            5 => 'txn_hash',
            6 => 'status'
        );

        $user = auth()->user();

        $limit = $request->input('length');
        $start = $request->input('start');

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (!empty($request->input('search.value'))) {
            $transactionsQuery = WalletTransfer::where(function ($query) use ($txid, $user) {
                $query->where('user_id', $user->id);
            })
                ->when(request()->input('search.value'), function ($query) {
                    $query->where('txn_hash', 'like', '%' . request()->input('search.value') . '%')
                        ->orWhere('txid', 'like', '%' . request()->input('search.value') . '%');
                })
                ->where('status', 1)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir);

            $transactions = $transactionsQuery->get();
            $totalFiltered = $totalData = $transactionsQuery->count();
        } else {

            $transactionsQuery = WalletTransfer::where(function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
                ->where('status', 1)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir);

            $transactions = $transactionsQuery->get();
            $totalFiltered = $totalData = $transactionsQuery->count();
        }
        $data = array();
        $srNo = 1;
        $columns = array(
            0 => 'id',
            0 => 'created_at',
            1 => 'txid',
            2 => 'narration',
            3 => 'amount',
            4 => 'txn_hash',
            5 => 'status'
        );
        if (!empty($transactions)) {
            foreach ($transactions as $transaction) {
                $nestedData = array();
                $nestedData[] = $srNo++;
                $nestedData[] = date('Y-m-d H:i:s', strtotime($transaction->created_at));
                $nestedData[] = $transaction->txid;
                $nestedData[] = $transaction->naration;
                $nestedData[] = truncate_number($transaction->amount, 4);
                $nestedData[] = $transaction->txn_hash;

                if ($transaction->status == 1) {
                    $nestedData[] = 'Completed';
                } else {
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
}
