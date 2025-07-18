<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Deposit;
use DataTables;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $skip = isset($request->start) ? $request->start : 0;
            $take = isset($request->length)? $request->length : 10;
            $dates = $request->input('dates') != 'all' ? $request->input('dates') : '';
            
            if (isset($request->subtype)) {
                $data = Deposit::where('amount','>' ,'0');

                if(!empty($dates)){
                    $date_array = explode('-',$dates);
                    $fdate = date('Y-m-d',strtotime($date_array[0]));
                    $ldate = date('Y-m-d',strtotime($date_array[1]));
                    if($fdate === $ldate){
                        $data->where('added_on','LIKE',"%{$fdate}%");
                    }else{
                        $data->whereBetween('added_on', [$fdate, $ldate]);
                    }
                } 

                if (isset($request->search['value']) && $request->search['value'] != '') {
                    $search =  $request->search['value'];
                    $data = $data->where('txid', 'like', '%' . $search . '%')->orWhereHas('user', function ($query) use ($search) {
                        $query->where('email', 'like',  '%' . $search . '%');
                    });
                }

                $data = $data->where('subtype', $request->subtype)->where('status', $request->status)->orderBy('added_on', 'desc')->skip($skip)->take($take)->get();
                
                
                if (isset($request->search['value']) && $request->search['value'] != '') {
                    $count = $data->count();
                }else {
                    $count = Deposit::where('subtype', $request->subtype)->where('status', $request->status)->count();
                }
               
            } else {
                $data = Deposit::get();
                $count = Deposit::get()->count();
            }
           
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $edit = '<a href="'.route('deposits.edit', $row->id).'" class="custom-edit-btn mr-1">
                                    <i class="fe fe-pencil"></i>
                                        '.__('default.form.edit-button').'
                                </a>';
                   
                    $delete = '<button class="custom-delete-btn remove-user" data-id="'.$row->id.'" data-action="'.route('deposits.destroy').'">
										<i class="fe fe-trash"></i>
		                                '.__('default.form.delete-button').'
									</button>';
                    
                    $action = $edit.' '.$delete;
                    return $action;
                })

                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        $current_status = 'Completed';
                    } else {
                        $current_status = 'Pending';
                    }
                    return $current_status;
                })

                ->addColumn('subtype', function ($row) {
                    if ($row->subtype == 'bep20') {
                        $current_status = 'USDT';
                    } else{
                        $current_status = '';
                    }
                    return $current_status;
                })

                ->addColumn('user_id', function ($row) {
                    return $row->user->name;
                })

                ->addColumn('email', function ($row) {
                    return '<a href="'.route('users.info', $row->user->id).'">' . $row->user->email . '</a>';                    
                })

                ->addColumn('transaction_id', function ($row) {
                    return $row->transaction_id;
                })
                ->addColumn('currency', function ($row) {
                    return $row->currency? $row->currency : '-';
                })

                ->addColumn('txid', function ($row) {
                    $txnHashHtml = '-';
                    if ($row->txid) {
                        $shortenTransactionID = shortenTransactionID($row->txid, 10);
                        $anchorLink = '';
                        switch ($row->subtype) {
                            case 'uscnew':
                                $anchorLink = "https://ubitscan.com/tx/" . $row->txid;
                                break;
                            case 'bep20':
                                $anchorLink = "https://bscscan.com/tx/" . $row->txid;
                                break;
                        }
                        if ($anchorLink !== '') {
                            $txnHashHtml = "<a href='$anchorLink' target='_blank' title='$row->txid'>$shortenTransactionID</a>";
                        }
                    }
                    return $txnHashHtml;
                })
                ->editColumn('added_on', '{{date("Y-m-d H:i:s", strtotime($added_on))}}')
                // ->editColumn('updated_on', '{{date("jS M Y", strtotime($updated_on))}}')
                ->escapeColumns([])
                //->skipTotalRecords($recordscount)
                ->setTotalRecords($count)
                ->setFilteredRecords($count)
                ->skipPaging()
                ->make(true);
        }
        return view('admin.deposits.index');
    }

    public function status_update(Request $request)
    {
       
        $deposit = Deposit::find($request->id)->update(['status' => $request->status]);
        if($request->status == 1) {
            return response()->json(['message' => 'Status activated successfully.']);
        } else {
            return response()->json(['message' => 'Status deactivated successfully.']);
        }
    }

    public function create()
    {
        return view('admin.deposits.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'meta_key' 			=> 'required',
            'meta_value' 		=> 'required',
        ];

        $messages = [
            'meta_key.required'    		=> __('default.form.validation.name.required'),
            'meta_value.required'    	=> __('default.form.validation.email.required'),
        ];

        $this->validate($request, $rules, $messages);
        $input = request()->all();
        

        try {
            $deposit = Deposit::create($input);
            Toastr::success(__('deposit.message.store.success'));
            return redirect()->route('deposits.index');

        } catch (Exception $e) {
            Toastr::error(__('deposit.message.store.error'));
            return redirect()->route('deposits.index');
        }
    }

    public function edit($id)
    {
        $deposit = Deposit::find($id);
        return view('admin.deposits.edit', compact('deposit'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'meta_key' 			=> 'required',
            'meta_value' 		=> 'required',
        ];

        $messages = [
            'meta_key.required'    		=> __('default.form.validation.name.required'),
            'meta_value.required'    	=> __('default.form.validation.email.required'),
        ];

        
        $this->validate($request, $rules, $messages);
        $input = $request->all();
        $deposit = Deposit::find($id);
        try {
            $deposit->update($input);
            Toastr::success(__('deposit.message.update.success'));
            return redirect()->route('deposits.index');
        } catch (Exception $e) {
            Toastr::error(__('deposit.message.update.error'));
            return redirect()->route('deposits.index');
        }
    }

    public function destroy()
    {
        $id = request()->input('id');
        $all_setting = Deposit::all();
        $count_all_setting = $all_user->count();

        if ($count_all_setting <= 1) {
            Toastr::error(__('deposit.message.warning_last_user'));
            return redirect()->route('deposits.index');
        } else {
            try {
                Deposit::find($id)->delete();
                return back()->with(Toastr::error(__('deposit.message.destroy.success')));
            } catch (Exception $e) {
                $error_msg = Toastr::error(__('deposit.message.destroy.error'));
                return redirect()->route('deposits.index')->with($error_msg);
            }
        }
    }


}
