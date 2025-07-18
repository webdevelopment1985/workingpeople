<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Transaction;
use App\Models\JoiningHistory;

use DataTables;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use DB;

class UserController extends Controller
{
    public function __construct()
    {
    }
 
    public function index(Request $request, $flag=null)
    {
        if ($request->ajax()) {
            $skip = isset($request->start) ? $request->start : 0;
            $take = isset($request->length)? $request->length : 10;
            $dates = $request->input('dates') != 'all' ? $request->input('dates') : '';

            if (isset($request->is_verified)) {
                $data = User::where('users_type', 1);
                if(empty($request->input('flag'))){
                    $data ->where('is_verified', $request->is_verified);
                }
                else{
                    if($request->input('flag') != 1){
                        if($request->input('flag') == 2){
                            $data ->where('is_verified', $request->is_verified);
                        }
                        else if($request->input('flag') == 3){
                            $data ->where('is_verified', 0);
                        }
                        else if($request->input('flag') == 4){
                            $data ->where('is_paid', 1);
                        }
                    }
                }
                
                if(!empty($dates)){
                    $date_array = explode('-',$dates);
                    $fdate = date('Y-m-d',strtotime($date_array[0]));
                    $ldate = date('Y-m-d',strtotime($date_array[1]));
                    if($fdate === $ldate){
                        $data->where('created_at','LIKE',"%{$fdate}%");
                    }else{
                        $data->whereBetween('created_at', [$fdate, $ldate]);
                    }
                }

                if (isset($request->search['value']) && $request->search['value'] != '') {
                    $search =  $request->search['value'];
                    $data = $data->where('email', 'like',  '%' . $search . '%');
                }
                $data = $data->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();

                if (isset($request->search['value']) && $request->search['value'] != '') {
                    $count = $data->count();
                }else {
                    if(empty($request->input('flag'))){
                        $count = User::where('users_type', 1)->where('is_verified', $request->is_verified)->get()->count();
                    }else{
                        if($request->input('flag') == 1){
                            $count = User::where('users_type', 1)->get()->count();
                        }else if($request->input('flag') == 2){
                            $count = User::where('users_type', 1)->where('is_verified', $request->is_verified)->get()->count();
                        }else if($request->input('flag') == 3){
                            $count = User::where('users_type', 1)->where('is_verified', 0)->get()->count();
                            $data ->where('is_verified', 0);
                        }else if($request->input('flag') == 4){
                            $count = User::where('users_type', 1)->where('is_paid', 1)->get()->count();
                        }
                    }
                }
            } else {
                $data = User::where('users_type', 1)->orderBy('created_at', 'desc')->get();
                $count = User::where('users_type', 1)->get()->count();
            }
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    if ($row->status == 1) {
                        $info = '<a href="'.route('users.info', $row->id).'" class="custom-edit-btn mr-1" "> <i class="fe fe-eye"></i>
                        '.__('User Info').' </a><a href="'.route('admin.impersonate', $row->id).'" class="custom-edit-btn mr-1" "> <i class="fe fe-eye"></i>
                        '.__('Force Login').' </a> ';
                    } else {
                        $info = '<a href="'.route('users.info', $row->id).'" class="custom-edit-btn mr-1" "> <i class="fe fe-eye"></i>
                        '.__('User Info').' </a>';
                    }

                    
                    $action = $info;
                    return $action;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        $current_status = 'Checked';
                    } else {
                        $current_status = '';
                    }
                    $status = "
                            <input type='checkbox' id='status_$row->id' id='user-$row->id' class='check' onclick='changeUserStatus(event.target, $row->id);' " .$current_status. ">
                			<label for='status_$row->id' class='checktoggle'>checkbox</label>
                    ";
                    return $status;
                })
                ->addColumn('is_verified', function ($row) {
                    if ($row->is_verified == 1) {
                        $current_status = 'Checked';
                        $title = 'Verified';
                    } else {
                        $current_status = '';
                        $title = 'Not Verified';
                    }
                    $status = "
                            <input type='checkbox' id='is_verified_$row->id' id='is_verified-$row->id' class='check' onclick='changeUserVerifyStatus(event.target, $row->id);' " .$current_status. ">
							<label for='is_verified_$row->id' class='checktoggle' title='".$title."'>checkbox</label>
                    ";
                    return $status;
                })
                ->addColumn('is_paid', function ($row) {
                    return ($row->is_paid == 1) ? 'Yes' : 'No';
                })
                ->addColumn('wallet_amount', function ($row) {
                    return $row->wallet_amount;
                })
                ->addColumn('withdrawable_amount', function ($row) {
                    return $row->withdrawable_amount;
                })
                ->editColumn('created_at', '{{date("Y-m-d H:i:s", strtotime($created_at))}}')
                ->editColumn('updated_at', '{{date("jS M Y", strtotime($updated_at))}}')
                ->escapeColumns([])
                ->skipTotalRecords($count)
                ->setTotalRecords($count)
                ->setFilteredRecords($count)
                ->skipPaging()
                ->make(true);
        }
        return view('admin.users.index',compact('flag'));
    }

    public function view($id){
        $user = User::find($id);
        $sponsor = User::find($user->sponsor);
        $deposit_address = $user->getUsdtAddress();
        return view('admin.users.info',compact('user', 'sponsor', 'deposit_address'));
    }

    public function viewWithEmail($username){
        $user = User::where('username',$username)->first();
        $sponsor = User::find($user->sponsor);
        $deposit_address = $user->getUsdtAddress();
        return view('admin.users.info',compact('user', 'sponsor', 'deposit_address'));
    }

    public function transactions(Request $request, $id){
        
        $userId = $id;
        if ($request->ajax()) {
            $type = $request->input('mode') != 'all' ? $request->input('mode') : '';
            $trans_type = $request->input('trans_type') != 'all' ? $request->input('trans_type') : '';
            $status = $request->input('status') != 'all' ? $request->input('status') : '';
            $dates = $request->input('dates') != 'all' ? $request->input('dates') : '';

            $query = Transaction::with('user')->where('user_id',$request->input('user_id'));
            if (!empty($type)) {
                $query->where('type', $type);
            }
        
            if (!empty($trans_type)) {
                $query->where('trans_type', $trans_type);
            }
        
            if (!empty($status)) {
                $statuss = ($status == 2) ? 0 : $status;
                $query->where('status', $statuss);
            }

            if(!empty($dates)){
                $date_array = explode('-',$dates);
                $fdate = date('Y-m-d',strtotime($date_array[0]));
                $ldate = date('Y-m-d',strtotime($date_array[1]));
                if($fdate === $ldate){
                    $query->where('created_at','LIKE',"%{$fdate}%");
                }else{
                    $query->whereBetween('created_at', [$fdate, $ldate]);
                }
            }

            if (!empty($request->input('search.value'))) {
                $search = $request->input('search.value');
                $query->where(function ($q) use ($search) {
                    $q->where('amount', 'LIKE', "%{$search}%")
                    ->orWhere('trans_type', 'LIKE', "%{$search}%")
                    ->orWhere('type', 'LIKE', "%{$search}%")
                    ->orWhere('narration', 'LIKE', "%{$search}%")
                    ->orWhere('txid', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('username', 'like', '%' . $search . '%');
                    });
                });
            }
            $query->orderBy('created_at', 'desc');
            $query->get();
            
            return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('created_at', function ($row) {
                return date('Y-m-d H:i:s',strtotime($row->created_at));
            })->addColumn('username', function ($row) {
                return $row->user->username;
            })->addColumn('txid', function ($row) {
                if($row->currency == 'USDT' && !empty($row->txid)){
                    return '<a href="https://bscscan.com/tx/' . $row->txid . '" target="_blank" title="' . $row->txid . '">' . showHash($row->txid, 8) . '</a>';
                }
                else{
                    return showHash($row->txid,6);
                }                
            })->addColumn('type', function ($row) {
                return ucfirst($row->type);
            })->addColumn('trans_type', function ($row) {
                return ucfirst(str_replace("-", " ", $row->trans_type));
            })->addColumn('amount', function ($row) {
                return $row->amount;
            })->addColumn('narration', function ($row) {
                return $row->narration;
            })->addColumn('status', function ($row) {
                if($row->status == 0){
                    $status = "Pending";
                }else{
                    $status = "Completed";
                }
                return $status;
            })
            ->escapeColumns([])
            ->make(true);
        }
        return view('admin.users.transactions',compact('userId'));
    }

    public function transactionHistory(Request $request, $id){

        $userId = $id;
        
        if ($request->ajax()) {

            $type = $request->input('mode') != 'all' ? $request->input('mode') : '';
            $trans_type = $request->input('trans_type') != 'all' ? $request->input('trans_type') : '';
            $status = $request->input('status') != 'all' ? $request->input('status') : '';
            $dates = $request->input('dates') != 'all' ? $request->input('dates') : '';

            $query = Transaction::with('user')->where('user_id',$request->input('user_id'));
            if (!empty($type)) {
                $query->where('type', $type);
            }
        
            if (!empty($trans_type)) {
                $query->where('trans_type', $trans_type);
            }
        
            if (!empty($status)) {
                $statuss = ($status == 2) ? 0 : $status;
                $query->where('status', $statuss);
            }
            if(!empty($dates)){
                $date_array = explode('-',$dates);
                $fdate = date('Y-m-d',strtotime($date_array[0]));
                $ldate = date('Y-m-d',strtotime($date_array[1]));
                if($fdate === $ldate){
                    $query->where('created_at','LIKE',"%{$fdate}%");
                }else{
                    $query->whereBetween('created_at', [$fdate, $ldate]);
                }
            }

            if (!empty($request->input('search.value'))) {
                $search = $request->input('search.value');
                $query->where(function ($q) use ($search) {
                    $q->where('amount', 'LIKE', "%{$search}%")
                    ->orWhere('trans_type', 'LIKE', "%{$search}%")
                    ->orWhere('type', 'LIKE', "%{$search}%")
                    ->orWhere('narration', 'LIKE', "%{$search}%")
                    ->orWhere('txid', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('username', 'like', '%' . $search . '%');
                    });
                });
            }
            $query->orderBy('created_at', 'desc');
            $query->get();
            
            return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('created_at', function ($row) {
                return date('Y-m-d H:i:s',strtotime($row->created_at));
            })->addColumn('username', function ($row) {
                return $row->user->username;
            })->addColumn('txid', function ($row) {
                if($row->currency == 'USDT' && !empty($row->txid) && $row->trans_type == 'deposit'){
                    return '<a href="https://bscscan.com/tx/' . $row->txid . '" target="_blank" title="' . $row->txid . '">' . showHash($row->txid, 8) . '</a>';
                }
                else{
                    return showHash($row->txid,6);
                }                
            })->addColumn('type', function ($row) {
                return ucfirst($row->type);
            })->addColumn('trans_type', function ($row) {
                return ucfirst(str_replace("-", " ", $row->trans_type));
            })->addColumn('amount', function ($row) {
                return $row->amount;
            })->addColumn('narration', function ($row) {
                return $row->narration;
            })->addColumn('status', function ($row) {
                if($row->status == 0){
                    $status = "Pending";
                }else{
                    $status = "Completed";
                }
                return $status;
            })
            ->escapeColumns([])
            ->make(true);
        }
        return view('admin.users.transactions',compact('userId'));
    }

    public function team(Request $request, $id){

        $userId = $id;
        $userInfo = User::find($id);

        $groupedUsers = JoiningHistory::select('level', DB::raw('count(user_id) as user_count'))
        ->where('for_user_id', $userInfo->id)
        ->groupBy('level')
        ->get();

        if ($request->isMethod('post')) {

            $columns = array(
                0 => 'users.created_at',
                2 => 'users.username'
           );

            $limit = $request->input('length');
            $start = $request->input('start');

            $orderColumn = $columns[$request->input('order.0.column')];
            $orderDirection = $request->input('order.0.dir');

            $userFilters['username'] = $request->input('username');
            $userFilters['level'] = $request->input('level_no');

            $query1 = DB::table('joining_history as jh')
            ->select(
                'jh.id',
                'jh.user_id',
                'jh.for_user_id',
                'jh.level',
                'u.username',
                DB::raw('SUM(CASE WHEN trans_type = "deposit" AND type = "credit" THEN amount ELSE 0 END) as total_deposit'),
                DB::raw('SUM(CASE WHEN trans_type = "purchase" AND type = "debit" THEN amount ELSE 0 END) as total_invest'),
                DB::raw('SUM(CASE WHEN trans_type = "internal-transfer" AND type = "debit" THEN amount ELSE 0 END) as total_transfer_sent'),
                DB::raw('SUM(CASE WHEN trans_type = "internal-transfer" AND type = "credit" THEN amount ELSE 0 END) as total_transfer_received'),
                DB::raw('SUM(CASE WHEN trans_type = "roi-income" AND type = "credit" THEN amount ELSE 0 END) as total_roi_income'),
                DB::raw('SUM(CASE WHEN trans_type = "level-income" AND type = "credit" THEN amount ELSE 0 END) as total_level_income')
            )
            ->leftJoin('transactions as t', 't.user_id', '=', 'jh.user_id')
            ->leftJoin('users as u', 'u.id', '=', 'jh.user_id')
            ->where('jh.for_user_id', $userInfo->id)
            ->groupBy('jh.id', 'jh.user_id', 'jh.for_user_id', 'jh.level', 'u.username');

            if (isset($userFilters['level'])) {
                $query1->where('jh.level', $userFilters['level']);
            }

            $totalData = $query1->count();

            $allowedColumns = [
                'users.id',
                'users.username', 
                'users.email',
                'users.name', 
                'users.created_at'
            ];

            if (!in_array($orderColumn, $allowedColumns)) {
                $orderColumn = 'users.created_at';
            }
            
            if (!in_array($orderDirection, ['asc', 'desc'])) {
                $orderDirection = 'asc';
            }

            $query1->offset($start);
            $query1->limit($limit);

            $transactions = $query1->get();

            $data = array();
            $srNo = 1;

            if(!empty($transactions)) {
                foreach ($transactions as $transaction) {

                    $nestedData = array();
                    $nestedData[] = $srNo++;
                    $nestedData[] = $transaction->level;
                    $nestedData[] = $transaction->username;
                    $nestedData[] = formatNumber($transaction->total_deposit, 4);
                    $nestedData[] = formatNumber($transaction->total_transfer_received,4);
                    $nestedData[] = formatNumber($transaction->total_transfer_sent,4);
                    $nestedData[] = formatNumber($transaction->total_invest,4);
                    $nestedData[] = formatNumber($transaction->total_roi_income,4);
                    $nestedData[] = formatNumber($transaction->total_level_income,4);
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

        return view('admin.users.team',compact('userId', 'userInfo', 'groupedUsers'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function status_update(Request $request)
    {
        $user = User::find($request->id)->update(['status' => $request->status]);

        if($request->status == 1) {
            return response()->json(['message' => 'Status activated successfully.']);
        } else {
            return response()->json(['message' => 'Status deactivated successfully.']);
        }
    }

    public function verify_status_update(Request $request)
    {

          $user = User::where('id', $request->id)->update(['is_verified' => $request->is_verified]);
 
        if($request->is_verified == 1) {
            return response()->json(['message' => 'User verified successfully.']);
        } else {
            return response()->json(['message' => 'User  unverified successfully.']);
        }
    }

    public function active_users()
    {
        return view('templates.admin.active_users');
    }
    public function delete_users()
    {
        return view('templates.admin.delete_users');
    }
    public function all_orders()
    {
        return view('templates.admin.all_orders');
    }
    public function new_orders()
    {
        return view('templates.admin.new_orders');
    }
    public function shipped_orders()
    {
        return view('templates.admin.shipped_orders');
    }
    public function delivered_orders()
    {
        return view('templates.admin.delivered_orders');
    }


    public function viewUserBalanceAjax(Request $request)
    {
        if ($request->ajax()) {
            $user = User::find($request->id);
            if($user) {
                try {
                    $action_type = 'get_Account';
                    $actionTxt = 'address';
                    if($request->type == 1) {
                        $action_type = 'get_Balance';
                        $actionTxt = 'balance';
                    } elseif($request->type == 2) {
                        $action_type = 'get_Account';
                        $actionTxt = 'address';
                    }
                    
                    $data = array(
                        'usc'=>'',
                        'usdt'=>'',
                        'oldUbit'=>'',
                        'email'=>$user->email
                    );
                    $apiResponse = $this->cryptoAPI->make_api_call($action_type, ["Email" => $user->email]);
                    $status = false;
                    if(isset($apiResponse->message) && $apiResponse->message=='success') {
                        $status = true;
                        $message = $actionTxt . ' fetch success';
                        $data['usc'] = $request->type == 1 ? $apiResponse->balance : $apiResponse->address;
                        $data['usdt'] = $request->type == 1 ? $apiResponse->usdtBalance : $apiResponse->usdtAddress;
                        $data['oldUbit'] = $request->type == 1 ? $apiResponse->oldCoinBalance : $apiResponse->oldAddress;
                    } else {
                        $message = 'Unable to fetch user ' . $actionTxt;
                    }
                    return response()->json(['status' => $status, 'message'=>$message, 'data'=>$data]);
                } catch(Exception $e) {
                    Log::error('viewUserBalanceAjax[get_Balance] API Exception : ', ['message'=>$e->getMessage()]);
                    return response()->json(['status' => false, 'message'=>'Server did not response. Please try after sometimes', 'data'=>[]]);
                }
            } else {
                return response()->json(['status' => false, 'message'=>'User does not exist', 'data'=>$data]);
            }
        }
        return response()->json(['status' => false, 'message'=>'Invalid request', 'data'=>[]]);
    }

}