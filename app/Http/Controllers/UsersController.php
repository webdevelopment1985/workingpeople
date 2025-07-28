<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Deposit;
use App\Models\Invoice;
use App\Models\Swap;
use App\Models\Phases;
use App\Models\Transaction;
use App\Models\JoiningHistory;
use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Helper\CryptoAPI;
use Validator;
use DB;
use Log;

class UsersController extends Controller
{

    private $cryptoAPI;

    public function __construct()
    {
        // $this->cryptoAPI = new CryptoAPI();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    public function usdtPayment(Request $request)
    {
        // $deposit_address = auth()->user()->getUsdtAddress();
        $deposit_address = '0xad3b67BCA8935Cb510C8D18bD45F0b94F54A968f'; // Replace with actual logic to get deposit address
        if ($request->isMethod('post')) {
            $deposit = new Deposit();
            $totalSync = $deposit->syncTransactions('4', 'USDT');
            $message = (int)$totalSync > 0 ? $totalSync . " transaction(s) synced successfully" : " No transaction(s) synced";
            $json_data = ["R" => $deposit, "M" => $message, 'data' => $totalSync];
            return response()->json($json_data);
        }
        return view('templates.user.usdt', compact('deposit_address'));
    }

    public function uscPayment(Request $request) {}

    public function usdtSwap(Request $request) {}


    public function ubitSwap(Request $request) {}

    // Fetch records
    public function getSwaps(Request $request) {}


    public function getDeposits(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'method',
            2 => 'user_id',
            3 => 'created_on',
            4 => 'rec_address',
        );

        $user_id = auth()->user()->id;

        $totalData = Deposit::where('subtype', $request->method)->where('user_id', $user_id)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $deposits = Deposit::offset($start)->where('subtype', $request->method)->where('user_id', $user_id)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $posts =  Deposit::where('id', 'LIKE', "%{$search}%")
                ->orWhere('payment_id', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Deposit::where('id', 'LIKE', "%{$search}%")
                ->orWhere('payment_id', 'LIKE', "%{$search}%")
                ->count();
        }

        $srNo = 1;
        $data = array();
        if (!empty($deposits)) {
            foreach ($deposits as $deposit) {
                $nestedData = [];
                $nestedData = array();
                $nestedData[] = $srNo++;
                $nestedData[] = date('Y-m-d h:i:s', strtotime($deposit->added_on));
                $nestedData[] = $deposit->transaction_id;
                $nestedData[] = $deposit->amount;

                if ($deposit->subtype == 'bep20') {
                    $nestedData[] = '<a href="https://bscscan.com/tx/' . $deposit->txid . '" target="_blank">' . showHash($deposit->txid) . '</a>';
                } else {
                    $nestedData[] = '<a href="#" target="_blank">' . showHash($deposit->txid) . '</a>';
                }

                $nestedData[] = $deposit->naration;
                $nestedData[] = $deposit->status == 0 ? 'Pending' : 'Completed';
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


    public function buyPackage(Request $request)
    {
        $dataForView = array();
        $user = auth()->user()->refresh();

        $dataForView['title'] = 'Investment Plan';
        $dataForView['wallet_amount'] = auth()->user()->getBalance('usdt');

        $package_min_amount = get_settings('package_min_amount');
        $dataForView['package_min_amount'] = $package_min_amount;

        $package_monthly_return = get_settings('monthly_return');
        $dataForView['package_monthly_return'] = $package_monthly_return;

        $package_lock_in_period = get_settings('lock_in_period');
        $dataForView['package_lock_in_period'] = $package_lock_in_period;

        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric|min:1'
            ], [
                'amount.required' => 'The amount field is mandatory.',
                'amount.numeric' => 'The amount must be a number.'
            ]);

            if ($validator->passes()) {

                $amount = $request->amount;
                if ($amount < $package_min_amount) {
                    return response()->json(['R' => false, 'M' => 'Minimum investment amount is ' . $package_min_amount]);
                }

                if (auth()->user()->wallet_amount < $amount) {
                    return response()->json(['R' => false, 'M' => 'You have insufficient balance for investment !!']);
                }

                $invoice = new Invoice;
                $invoice->user_id = $user->id;
                $invoice->created_at = date("Y:m:d H:i:s");
                $invoice->updated_at = date("Y:m:d H:i:s");
                $invoice->amount = $amount;
                $invoice->months = $package_lock_in_period;

                $CarbonDate = Carbon::now();
                $CarbonDate->addMonths($package_lock_in_period);
                $invoice->mature_date = $CarbonDate->format('Y:m:d H:i:s');

                if ($invoice->save()) {
                    $lastInsertedId = $invoice->id;
                    $narration = 'User has invested of amount ' . $amount . ' USDT';
                    $transaction = (new Transaction())->updateUserBalance($user->id, $amount, 0, 'USDT', $narration, 'debit', 'purchase', 1, $lastInsertedId, null);
                    if ($transaction) {
                        Auth::user()->is_paid = 1;
                        Auth::user()->save();
                        add_user_logs(Auth::user()->id, 'invest', $narration);
                        // $user = User::find($user->id);
                        $user->refresh();
                        return response()->json(['R' => true, 'M' => "Payment done successfully", 'data' => ['wallet_amount' => $user->wallet_amount]]);
                    } else {
                        return response()->json(['R' => false, 'M' => 'Failed to deduct balance!']);
                    }
                } else {
                    return response()->json(['R' => false, 'M' => 'Failed to Invest!']);
                }
            } else {
                return response()->json(['R' => false, 'M' => $validator->errors()->all()]);
            }
        }
        return view('templates.user.buy_packages', $dataForView);
    }

    // Fetch records
    public function getPurchaseHistory(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'method',
            2 => 'user_id',
            3 => 'created_at',
            4 => 'rec_address',
        );

        $user = auth()->user();

        $limit = $request->input('length');
        $start = $request->input('start');

        $type = $request->input('type');

        $totalData = Transaction::where('user_id', $user->id)->where('trans_type', $type)->count();
        $totalFiltered = $totalData;

        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (!empty($request->input('search.value'))) {

            $search = $request->input('search.value');
            $swaps =  Transaction::where('currency', "%{$search}%")
                ->orWhere('narration', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Invoice::where('receiving_address', 'LIKE', "%{$search}%")
                ->orWhere('receiving_address', 'LIKE', "%{$search}%")
                ->count();
        } else {
            $swaps = Transaction::offset($start)->where('user_id', $user->id)
                ->where('trans_type', $type)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }

        $data = array();
        $srNo = 1;
        if (!empty($swaps)) {
            foreach ($swaps as $swap) {
                $nestedData = array();
                $nestedData[] = $srNo++;
                $nestedData[] = $swap->created_at;
                $nestedData[] = $swap->amount;
                $nestedData[] = $swap->narration;
                $nestedData[] = $swap->status == 0 ?  'Pending' : 'Success';
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


    public function transactions(Request $request)
    {
        $dataForView = array();
        $dataForView['title'] = 'All Transactions';
        $dataForView['transaction_types'] = array(
            'all' => '-Choose-',
            'deposit' => 'Deposit',
            'purchase' => 'Purchase',
            'roi-income' => 'Roi-income',
            'level-income' => 'Level-income',
            'internal-transfer' => 'Transfer',
            'withdraw' => 'Withdraw'
        );
        return view('templates.user.transactions', $dataForView);
    }

    public function getTransactions(Request $request)
    {
        $columns = [
            0 => 'id',
            1 => 'created_at',
            2 => 'txid',
            3 => 'type',
            4 => 'trans_type',
            5 => 'amount',
            6 => 'narration',
            7 => 'status',
        ];

        $user = auth()->user();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        $filters = [
            'type'       => $request->input('type') !== 'all' ? $request->input('type') : null,
            'trans_type' => $request->input('trans_type') !== 'all' ? $request->input('trans_type') : null,
            'status'     => $request->input('status') !== 'all' ? $request->input('status') : null,
            'txnId'      => $request->input('txnId') ?? null,
            'from_date'  => $request->input('from_date') ?? null,
            'to_date'    => $request->input('to_date') ?? null,
        ];

        $query = Transaction::where('user_id', $user->id);

        if ($filters['type']) {
            $query->where('type', $filters['type']);
        }
        if ($filters['trans_type']) {
            $query->where('trans_type', $filters['trans_type']);
        }
        if ($filters['status'] !== null) {
            $query->where('status', $filters['status']);
        }
        if ($filters['txnId']) {
            $query->where('txid', 'LIKE', "%{$filters['txnId']}%");
        }
        if ($filters['from_date']) {
            $query->whereDate('created_at', '>=', $filters['from_date']);
        }
        if ($filters['to_date']) {
            $query->whereDate('created_at', '<=', $filters['to_date']);
        }

        $totalData = $query->count();

        # Fetch the results with pagination and sorting
        $transactions = $query
            ->orderBy($order, $dir)
            ->offset($start)
            ->limit($limit)
            ->get();

        $data = $transactions->map(function ($transaction, $index) {
            $txidLink = $transaction->txid && $transaction->trans_type === 'deposit'
                ? '<a href="https://bscscan.com/tx/' . $transaction->txid . '" target="_blank" title="' . $transaction->txid . '">' . showHash($transaction->txid, 8) . '</a>'
                : '';

            $typeBadge = $transaction->type === 'credit'
                ? '<span class="badge-grey">Credit</span>'
                : '<span class="badge-info">Debit</span>';

            $statusBadge = $transaction->status == 0
                ? '<span class="badge-danger">Pending</span>'
                : '<span class="badge-success">Complete</span>';

            $amount = $transaction->type === 'credit'
                ? '+' . truncate_number($transaction->amount, 4)
                : '-' . truncate_number($transaction->amount, 4);

            return [
                ++$index,
                $transaction->created_at,
                $txidLink,
                $typeBadge,
                $amount,
                str_replace('-', ' ', $transaction->trans_type),
                $transaction->narration,
                $statusBadge,
            ];
        })->toArray();

        return response()->json([
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalData),  // Same as totalData since no further filtering is applied after count
            "data"            => $data,
        ]);
    }

    public function syncSwapTransactions(Request $request)
    {
        if ($request->isMethod('post')) {
            $swap = new Swap();
            $swap = $swap->syncTransactions($request->trans, 'USDT');
            $message = $swap ? "Successfully Sync" : " No records Found";
            $json_data = ["R" => $swap, "M" => $message];
            return response()->json($json_data);
        }
        return response()->json(["R" => false, 'M' => "Invalid Request"]);
    }

    public function syncBuyTransactions(Request $request) {}

    public function teams(Request $request)
    {

        $dataForView = array();
        $dataForView['title'] = 'My Team';
        $user = auth()->user();
        $dataForView['groupedUsers'] = JoiningHistory::select('level', DB::raw('count(user_id) as user_count'))
            ->where('parent_user_id', $user->id) // Filter by parent_user_id
            ->groupBy('level')
            ->get();


        return view('templates.user.teams', $dataForView);
    }



    public function getTeams(Request $request)
    {
        $columns = array(
            0 => 'users.id',
            1 => 'users.username',
            2 => 'users.email',
            3 => 'users.name',
            6 => 'users.created_at'
        );

        $user = auth()->user();

        $limit = $request->input('length');
        $start = $request->input('start');

        $userFilters['username'] = $request->input('username');
        $userFilters['trans_type'] = $request->input('trans_type');
        $userFilters['status'] = $request->input('status');
        $userFilters['txnId'] = $request->input('txnId');


        $orderColumn = $columns[$request->input('order.0.column')];
        $orderDirection = $request->input('order.0.dir');

        if (!empty($request->input('search.value'))) {

            $search = $request->input('search.value');
            $transactions =  JoiningHistory::where('parent_user_id', $user->id) // Filter by parent_user_id
                ->with(['User' => function ($query) {
                    $query->select('id', 'username', 'name', 'email', 'created_at', 'is_paid'); // Select specific user fields
                }])
                ->Where('level', $trans_type)
                ->Where('is_paid', $status)

                ->Where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('username', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = JoiningHistory::where('parent_user_id', $user->id) // Filter by parent_user_id
                ->with('User')
                ->Where('level', $trans_type)
                ->Where('is_paid', $status)

                ->Where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('username', 'LIKE', "%{$search}%")
                ->count();
        } else {

            $query1 = JoiningHistory::query(); // Start the base query

            // Filter by parent_user_id
            $query1->where('parent_user_id', $user->id);

            // Join the users table to access fields like 'username'
            $query1->join('users', 'users.id', '=', 'joining_history.user_id');

            // Apply filters related to the User model
            if (isset($userFilters['username'])) {
                $query1->where('users.username', 'like', '%' . $userFilters['username'] . '%');
            }

            if (isset($userFilters['status']) && $userFilters['status'] != 'all') {
                $query1->where('users.is_paid', $userFilters['status']);
            }

            // Select specific fields from the related User model
            $query1->with(['User' => function ($query) {
                $query->select('id', 'username', 'name', 'email', 'created_at'); // Select specific fields
            }]);

            // Apply the level filter if trans_type is set
            if (isset($userFilters['trans_type'])) {
                $query1->where('level', $userFilters['trans_type']);
            }

            // Get the total count before applying pagination
            $totalData = $query1->count();


            // Allowed columns for sorting (including user-related columns)
            $allowedColumns = [
                'users.id',
                'users.username',
                'users.email',
                'users.name',
                'users.created_at'
            ];


            // Validate the sorting column to prevent SQL injection
            if (!in_array($orderColumn, $allowedColumns)) {
                $orderColumn = 'users.created_at'; // Fallback to default if not valid
            }

            // Ensure the order direction is either 'asc' or 'desc'
            if (!in_array($orderDirection, ['asc', 'desc'])) {
                $orderDirection = 'asc'; // Fallback to ascending if the direction is invalid
            }

            $query1->orderBy($orderColumn, $orderDirection);

            // Apply pagination, ordering, and limit
            $transactions = $query1->offset($start)
                ->limit($limit)
                ->get();
        }
        $data = array();
        $srNo = 1;

        if (!empty($transactions)) {
            foreach ($transactions as $transaction) {
                $nestedData = array();
                $nestedData[] = $srNo++;
                $nestedData[] = $transaction->User->username;

                $nestedData[] = $transaction->User->email;
                $nestedData[] = $transaction->User->name;

                $nestedData[] =  '<span ><a href="javascript:void" onclick=getTotalInvestment(this,' . $transaction->User->id . ') title="View Total Investment">Click to view</a></span>';
                $nestedData[] =  '<span><a href="javascript:void" onclick=getTotalLevelIncome(this,' . $transaction->User->id . ') title="View Level Commission">Click to view</a></span>';
                $nestedData[] =  '<span><a href="javascript:void" onclick=getTotalDeposit(this,' . $transaction->User->id . ') title="View total Deposit">Click to view</a></span>';

                $nestedData[] =  $transaction->User->created_at->format('Y:m:d H:i:s');

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalData),
            "data"            => $data
        );

        return response()->json($json_data);
    }



    public function getTotalInvestment(Request $request)
    {
        /// Ensure the request is an AJAX request
        if (!$request->ajax()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // Fetch the user_id from the POST request body
        $userId = $request->input('user_id');

        // Fetch total investment for the user with the provided user_id
        $totalInvestment = Invoice::where('user_id', $userId)
            ->sum('amount'); // Replace 'amount' with the correct column for the investment

        // Return the total investment as a JSON response
        return response()->json(['total_investment' => $totalInvestment]);
    }



    public function getTotalDeposit(Request $request)
    {
        /// Ensure the request is an AJAX request
        if (!$request->ajax()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // Fetch the user_id from the POST request body
        $userId = $request->input('user_id');

        // Fetch total investment for the user with the provided user_id
        $totalInvestment = Transaction::where('user_id', $userId)
            ->where('trans_type', 'deposit')  // Only include deposits
            ->sum('amount');

        // Return the total investment as a JSON response
        return response()->json(['total_investment' => $totalInvestment]);
    }


    public function getTotalLevelIncome(Request $request)
    {
        /// Ensure the request is an AJAX request
        if (!$request->ajax()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        // Fetch the user_id from the POST request body
        $userId = $request->input('user_id');

        // Fetch total investment for the user with the provided user_id
        $totalIncome = Transaction::where('user_id', $userId)
            ->where('trans_type', 'level-income')
            ->sum('amount'); // Replace 'amount' with the correct column for the investment

        // Return the total investment as a JSON response
        return response()->json(['total_income' => $totalIncome]);
    }


    public function internalTransfer(Request $request)
    {
        $dataForView = array();
        $user = auth()->user();

        $dataForView['title'] = 'Internal Transfer';
        $dataForView['wallet_amount'] = auth()->user()->getBalance('usdt');

        $package_min_amount = get_settings('package_min_amount');
        $dataForView['package_min_amount'] = $package_min_amount;

        $package_monthly_return = get_settings('monthly_return');
        $dataForView['package_monthly_return'] = $package_monthly_return;

        $package_lock_in_period = get_settings('lock_in_period');
        $dataForView['package_lock_in_period'] = $package_lock_in_period;

        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric|min:1'
            ], [
                'amount.required' => 'The amount field is mandatory.',
                'amount.numeric' => 'The amount must be a number.'
            ]);

            if ($validator->passes()) {

                $amount = $request->amount;
                if ($amount < $package_min_amount) {
                    return response()->json(['R' => false, 'M' => 'Minimum package amount is ' . $package_min_amount]);
                }

                if (auth()->user()->wallet_amount < $package_min_amount) {
                    return response()->json(['R' => false, 'M' => 'You have insufficient balance for investment !!']);
                }

                $invoice = new Invoice;
                $invoice->user_id = $user->id;
                $invoice->created_at = date("Y:m:d H:i:s");
                $invoice->updated_at = date("Y:m:d H:i:s");
                $invoice->amount = $amount;
                $invoice->months = $package_lock_in_period;

                $CarbonDate = Carbon::now();
                $CarbonDate->addMonths($package_lock_in_period);
                $invoice->mature_date = $CarbonDate->format('Y:m:d H:i:s');

                if ($invoice->save()) {
                    $lastInsertedId = $invoice->id;
                    $narration = 'User has invested of amount ' . $amount . ' USDT';
                    $transaction = (new Transaction())->updateUserBalance($user->id, $amount, 0, 'USDT', $narration, 'debit', 'purchase', 1, $lastInsertedId, null);
                    if ($transaction) {
                        Auth::user()->is_paid = 1;
                        Auth::user()->save();
                        add_user_logs(Auth::user()->id, 'invest', $narration);
                        // $user = User::find($user->id);
                        $user->refresh();
                        return response()->json(['R' => true, 'M' => "Payment done successfully", 'data' => ['wallet_amount' => $user->wallet_amount]]);
                    } else {
                        return response()->json(['R' => false, 'M' => 'Failed to deduct balance!']);
                    }
                } else {
                    return response()->json(['R' => false, 'M' => 'Failed to Invest!']);
                }
            } else {
                return response()->json(['R' => false, 'M' => $validator->errors()->all()]);
            }
        }
        return view('templates.user.internalTransfer', $dataForView);
    }
}
