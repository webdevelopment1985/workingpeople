<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Transaction;
use DataTables;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

// use App\Models\Transactions;

class TransactionsController extends Controller
{
    public function index(Request $request, $flag=null)
    {        
        return view('admin.transactions.index',compact('flag'));
    }

    public function history(Request $request)
    {
        $type = $request->input('mode') != 'all' ? $request->input('mode') : '';
        $trans_type = $request->input('trans_type') != 'all' ? $request->input('trans_type') : '';
        $status = $request->input('status') != 'all' ? $request->input('status') : '';
        $dates = $request->input('dates') != 'all' ? $request->input('dates') : '';

        $query = Transaction::with('user');
        if (!empty($type)) {
            $query->where('type', $type);
        }
    
        if(empty($request->input('flag'))){
            if (!empty($trans_type)) {
                $query->where('trans_type', $trans_type);
            }
        }else{
            if($request->input('flag') == 'roi-income'){
                $query->where('trans_type', 'roi-income');
            }
            if($request->input('flag') == 'level-income'){
                $query->where('trans_type', 'level-income');
            }
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
            return '<a href="'.route('users.info', $row->user->id).'">' . $row->user->username . '</a>';
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

}