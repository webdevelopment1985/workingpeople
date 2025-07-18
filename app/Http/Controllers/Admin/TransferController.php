<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\InternalTransfer;
use DataTables;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function history(Request $request)
    {
        if ($request->ajax()) {

            $skip = isset($request->start) ? $request->start : 0;
            $take = isset($request->length)? $request->length : 10;
            
            if (isset($request->status)) {

                $data = InternalTransfer::where('amount', '!=', '');
                if (isset($request->search['value']) && $request->search['value'] != '') {
                    $search =  $request->search['value'];
                    $data = $data->where('transactionId', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('email', 'like', '%' . $search . '%');
                    });
                }
                $data = $data->where('status', $request->status)
                ->orderBy('created_at', 'desc')
                ->skip($skip)
                ->take($take)
                ->get();

                if (isset($request->search['value']) && $request->search['value'] != '') {
                    $count = $data->count();
                } else {
                    $count = InternalTransfer::where('status', $request->status)->count();
                }
            } else {
                $data = InternalTransfer::get();
                $count = InternalTransfer::count();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $edit = '<a href="'.route('invoices.edit', $row->id).'" class="custom-edit-btn mr-1">
                                    <i class="fe fe-pencil"></i>
                                        '.__('default.form.edit-button').'
                                </a>';
                   
                    $delete = '<button class="custom-delete-btn remove-user" data-id="'.$row->id.'" data-action="'.route('invoices.destroy').'">
										<i class="fe fe-trash"></i>
		                                '.__('default.form.delete-button').'
									</button>';
                    
                    $action = $edit.' '.$delete;
                    return $action;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        $status = 'Completed';
                    } else {
                        $status = 'Pending';
                    }
                    return $status;
                })
                ->addColumn('fromUser', function ($row) {
                    return '<a href="'.route('users.info', $row->fromUser->id).'">' . $row->fromUser->username . '</a>';
                })
                ->addColumn('toUser', function ($row) {
                    return '<a href="'.route('users.info', $row->toUser->id).'">' . $row->toUser->username . '</a>';
                })
                ->addColumn('transactionId', function ($row) {
                    return $row->transactionId;
                })
                ->editColumn('created_at', '{{date("Y-m-d H:i:s", strtotime($created_at))}}')
                ->escapeColumns([])
                ->skipTotalRecords($count)
                ->setTotalRecords($count)
                ->setFilteredRecords($count)
                ->skipPaging()
                ->make(true);
        }
        return view('admin.transfer.history');
    }

}
