<?php

namespace App\Http\Controllers\Admin;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use DataTables;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function dashboard()
    {
        $view_data = [];
        $userStats = User::selectRaw('
            COUNT(*) as total_users,
            SUM(is_verified = 1) as total_users_verified,
            SUM(is_verified = 0) as total_users_not_verified,
            SUM(is_paid = 1) as total_ib
        ')
        ->where('users_type', 1)
        ->first();

        $view_data['total_users'] = formatNumber($userStats->total_users);
        $view_data['total_users_verified'] = formatNumber($userStats->total_users_verified);
        $view_data['total_users_not_verified'] = formatNumber($userStats->total_users_not_verified);
        $view_data['total_ib'] = formatNumber($userStats->total_ib);

        $total_bep20_usdt = Deposit::where(['txn_type' => 'deposit', 'status' => 1])->sum('amount');

        $withdrawal_sums = Withdraw::selectRaw('status, SUM(w_amount) as total')
        ->whereIn('status', [0, 1, 2, 3])
        ->groupBy('status')
        ->pluck('total', 'status');
        $total_withdrawal_pending = $withdrawal_sums[0] ?? 0;
        $total_withdrawal_approved = $withdrawal_sums[1] ?? 0;
        $total_withdrawal_rejected = $withdrawal_sums[2] ?? 0;
        $total_withdrawal_cancelled = $withdrawal_sums[3] ?? 0;

        $total_purchase = Invoice::where('status', 1)->sum('amount');

        $view_data['total_bep20_usdt'] = formatNumber($total_bep20_usdt, 4);
        $view_data['total_withdrawal_pending'] = formatNumber($total_withdrawal_pending, 4);
        $view_data['total_withdrawal_approved'] = formatNumber($total_withdrawal_approved, 4);
        $view_data['total_withdrawal_rejected'] = formatNumber($total_withdrawal_rejected, 4);
        $view_data['total_withdrawal_cancelled'] = formatNumber($total_withdrawal_cancelled, 4);
        
        $view_data['total_purchase'] = formatNumber($total_purchase, 4);

        $Transaction = new Transaction();
        $view_data['total_roi_distributed'] = formatNumber($Transaction->adminTotalIncome('roi-income'), 4);
        $view_data['total_level_distributed'] = formatNumber($Transaction->adminTotalIncome('level-income'), 4);

        return view('admin.dashboard', $view_data);
    }


    public function loginOTP()
    {
        $view_data = array();
        return view('admin.loginOTP', $view_data);
    }

    

    public function logs(Request $request){
        if ($request->ajax()) {
            $data = DB::table('admin_logs')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('ip', function ($row) {
                    return $row->ip;
                })
                ->addColumn('agent', function ($row) {
                    return $row->agent;
                })
                ->addColumn('naration', function ($row) {
                    return $row->naration;
                })
                ->addColumn('type', function ($row) {
                    return ucfirst($row->type);
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.logs');
    }

    public function userlogs(Request $request){
        if ($request->ajax()) {
            $data = DB::table('user_logs')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('ip', function ($row) {
                    return $row->ip;
                })
                ->addColumn('agent', function ($row) {
                    return $row->agent;
                })
                ->addColumn('naration', function ($row) {
                    return $row->naration;
                })
                ->addColumn('type', function ($row) {
                    return ucfirst($row->type);
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.users.logs');
    }
}