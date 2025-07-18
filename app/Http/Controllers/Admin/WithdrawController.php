<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Withdraw;
use App\Models\User;
use DataTables;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helper\CryptoAPI;

class WithdrawController extends Controller
{
    private $crypto;

    public function __construct()
    {
        $this->crypto = new CryptoAPI();
    }

    public function index(Request $request,$flag=null)
    {
        // szs
        return view('admin.withdraw.index',compact('flag'));
    }

    public function allWithdrawals(Request $request)
    {
        if ($request->ajax()) {
            $currency = $request->post('currency');
            $search_by = $request->post('search_by');
            $txn_status = $request->post('txn_status') ?? '0';
            $email = ($search_by == 'email') ? $request->post('search_value') : '';
            $username = ($search_by == 'username') ? $request->post('search_value') : '';
            $hash = ($search_by == 'hash') ? $request->post('search_value') : '';
            $withdrawal = ($search_by == 'withdrawal_id') ? $request->post('search_value') : '';

            if ($username) {
                $user = User::where('username', $username)->first();
                $email = $user ? $user->email : '';
            }

            $start = $request->post('start') ?? 0;
            $length = $request->post('length') != -1 ? $request->post('length') : 100000000;

            $column_order = ['createdDate', 'transactionId', 'hash', 'userID', 'email', 'currency', 'amount', 'fees', 'amount', 'recieverAddress', '', 'gatewayStatus'];
            $order_column = $request->input('order.0.column') ?? 0;
            $SortName = $column_order[$order_column] ?? 'createdDate';
            $SortOrder = $request->input('order.0.dir') ?? 'DESC';

            $decoded_data = $this->crypto->make_api_call('withdraw_transactions_all', [
                "Email" => $email,
                "TransactionId" => $withdrawal,
                "Hash" => $hash,
                "Status" => $txn_status,
                "RecieverAddress" => $request->post('RecieverAddress'),
                "Currency" => $currency ? $currency : "USDT",
                "Token" => "",
                "Take" => $length,
                "Skip" => $start,
                "SortName" => $SortName,
                "SortOrder" => $SortOrder,
            ]);

            $responseData = [];
            // dd($decoded_data->data);
            foreach ($decoded_data->data as $data) {
                $statusDetails = match ($data->statusCode) {
                    4 => ['class' => 'alert-success', 'name' => 'Completed'],
                    13 => ['class' => 'alert-danger', 'name' => 'Suspicious'],
                    12 => ['class' => 'alert-info', 'name' => 'Processing'],
                    6 => ['class' => 'alert-info', 'name' => 'Rejected'],
                    8 => ['class' => 'alert-warning', 'name' => 'In Review'],
                    7 => ['class' => 'alert-danger', 'name' => 'Error'],
                    default => ['class' => 'alert-warning', 'name' => $data->status],
                };

                // $alink = match ($data->currency) {
                //     'USDT', 'UMT' => "https://bscscan.com/tx/" . $data->hash,
                //     'USC', 'UBIT' => "https://ubitscan.io/tx/" . $data->hash,
                //     default => null,
                // };

                $alink = "https://bscscan.com/tx/" . $data->hash;

                $responseData[] = [
                    date('d/m/Y g:i a', strtotime($data->createdDate)),
                    $data->transactionId,
                    $data->statusCode == 4 && $alink ? "<a href={$alink} target='_blank'>" . showHash($data->hash) . "</a>" : "-",
                    '<a href="' . route('users.details', $data->userID) . '">' . $data->userID . '</a>',
                    '<a href="' . route('users.details', $data->userID) . '">' . $data->email . '</a>',
                    $data->currency,
                    number_format($data->amount + $data->fees, 8),
                    number_format($data->fees, 8),
                    number_format($data->amount, 8),
                    "<span class='{$statusDetails['class']}'>{$statusDetails['name']}</span>",
                    $data->recieverAddress,
                    '',
                ];
            }

            return response()->json([
                "draw" => $request->post('draw'),
                "recordsTotal" => $decoded_data->count,
                "recordsFiltered" => $decoded_data->count,
                "data" => $responseData,
            ]);
        }

        return response()->json(['error' => 'Unauthorized Access'], 403);
    }
}