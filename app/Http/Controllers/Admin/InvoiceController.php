<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Invoice;
use DataTables;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helper\CryptoAPI;

class InvoiceController extends Controller
{

    private $cryptoAPI;

    public function __construct()
    {
        $this->cryptoAPI = new CryptoAPI();
    }

    public function index(Request $request){
        if ($request->ajax()) {
            $skip = isset($request->start) ? $request->start : 0;
            $take = isset($request->length)? $request->length : 10;
            
            $dates = $request->input('dates') != 'all' ? $request->input('dates') : '';

            $data = Invoice::with('user')->where('amount', '!=', '');

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
                $data = $data->where('months', 'like', '%' . $search . '%')
                ->orWhere('amount', 'like', '%' . $search . '%')
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('email', 'like', '%' . $search . '%');
                });
            }

            $data = $data->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user_id', function ($row) {
                    return $row->user->username;
                })
                ->addColumn('status', function ($row) {
                    $emailAddress = $row->user->email;
                    $sync = "<a href='javascript:void(0);' onClick=syncBuy('$row->crypto_txn_id','$emailAddress'); title='SHOW' ><span class='glyphicon glyphicon-list'></span>Pending</a>";
                    
                    if ($row->status == 1) {
                        $status = 'Completed';
                    } else {
                        $status = $sync;
                    }
                    return $status;
                })
                ->addColumn('user_id', function ($row) {
                    return '<a href="'.route('users.info', $row->user->id).'">' . $row->user->username . '</a>';
                })
                ->addColumn('email', function ($row) {
                    return '<a href="'.route('users.info', $row->user->id).'">' . $row->user->email . '</a>';
                })
                ->addColumn('months', function ($row) {
                    return $row->months;
                })
                ->addColumn('mature_date', function ($row) {
                    return date("Y-m-d", strtotime($row->mature_date));
                })
                ->editColumn('created_at', '{{date("Y-m-d", strtotime($created_at))}}')
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.invoices.index');
    }

    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $skip = isset($request->start) ? $request->start : 0;
    //         $take = isset($request->length)? $request->length : 10;
    //         $dates = $request->input('dates') != 'all' ? $request->input('dates') : '';
            
    //         // if (isset($request->status)) {

    //             $data = Invoice::with('user')->where('amount', '!=', '');

    //             if(!empty($dates)){
    //                 $date_array = explode('-',$dates);
    //                 $fdate = date('Y-m-d',strtotime($date_array[0]));
    //                 $ldate = date('Y-m-d',strtotime($date_array[1]));
    //                 if($fdate === $ldate){
    //                     $data->where('created_at','LIKE',"%{$fdate}%");
    //                 }else{
    //                     $data->whereBetween('created_at', [$fdate, $ldate]);
    //                 }
    //             } 

    //             if (isset($request->search['value']) && $request->search['value'] != '') {
    //                 $search =  $request->search['value'];
    //                 $data = $data->where('hash', 'like', '%' . $search . '%')
    //                 ->orWhere('receiving_address', 'like', '%' . $search . '%')
    //                 ->orWhereHas('user', function ($query) use ($search) {
    //                     $query->where('email', 'like', '%' . $search . '%');
    //                 });
    //             }
                
    //             $data = $data->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();

    //             if (isset($request->search['value']) && $request->search['value'] != '') {
    //                 $count = $data->count();
    //             } else {
    //                 $count = Invoice::where('status', $request->status)->count();
    //             }
    //             // $data = Invoice::where('status', $request->status)->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
    //             // $count = Invoice::where('status', $request->status)->get()->count();
    //         // } else {
    //         //     die('dfjfdjbhk');
    //         //     $data = Invoice::get();
    //         //     $count = Invoice::get()->count();
    //         // }
    //         // dd($data);
    //         return Datatables::of($data)
    //             ->addIndexColumn()
    //             // ->addColumn('action', function ($row) {
    //             //     $edit = '<a href="'.route('invoices.edit', $row->id).'" class="custom-edit-btn mr-1">
    //             //                     <i class="fe fe-pencil"></i>
    //             //                         '.__('default.form.edit-button').'
    //             //                 </a>';
                   
    //             //     $delete = '<button class="custom-delete-btn remove-user" data-id="'.$row->id.'" data-action="'.route('invoices.destroy').'">
	// 			// 						<i class="fe fe-trash"></i>
	// 	        //                         '.__('default.form.delete-button').'
	// 			// 					</button>';
                    
    //             //     $action = $edit.' '.$delete;
    //             //     return $action;
    //             // })
   
    //             ->addColumn('created_at', function ($row) {
    //                 return date("Y-m-d H:i:s", strtotime($row->created_at));
    //             })
    //             ->addColumn('user_id', function ($row) {
    //                 return $row->user->username;
    //             })
    //             ->addColumn('email', function ($row) {
    //                 return $row->user->email;
    //             })
    //             ->addColumn('months', function ($row) {
    //                 return $row->months;
    //             })
    //             ->addColumn('mature_date', function ($row) {
    //                 return date("Y-m-d H:i:s", strtotime($row->mature_date));
    //             })
    //             // ->addColumn('distributed_months', function ($row) {
    //             //     return $row->distributed_months;
    //             // })
    //             // ->editColumn('created_at', '{{date("Y-m-d H:i:s", strtotime($created_at))}}')
    //             ->escapeColumns([])
    //             ->skipTotalRecords($count)
    //             ->setTotalRecords($count)
    //             ->setFilteredRecords($count)
    //             ->skipPaging()
    //             ->make(true);
    //     }
    //     return view('admin.invoices.index');
    // }

    public function status_update(Request $request)
    {
        $setting = Invoice::find($request->id)->update(['status' => $request->status]);
        if($request->status == 1) {
            return response()->json(['message' => 'Status activated successfully.']);
        } else {
            return response()->json(['message' => 'Status deactivated successfully.']);
        }
    }

    public function create()
    {
        return view('admin.invoices.create');
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
            $setting = Invoice::create($input);
            Toastr::success(__('invoice.message.store.success'));
            return redirect()->route('invoices.index');

        } catch (Exception $e) {
            Toastr::error(__('invoice.message.store.error'));
            return redirect()->route('invoices.index');
        }
    }

    public function edit($id)
    {
        $setting = Invoice::find($id);
        return view('admin.invoices.edit', compact('setting'));
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
        $setting = Invoice::find($id);
        try {
            $setting->update($input);
            Toastr::success(__('invoice.message.update.success'));
            return redirect()->route('invoices.index');
        } catch (Exception $e) {
            Toastr::error(__('invoice.message.update.error'));
            return redirect()->route('invoices.index');
        }
    }

    public function destroy()
    {
        $id = request()->input('id');
        $all_setting = Invoice::all();
        $count_all_setting = $all_user->count();

        if ($count_all_setting <= 1) {
            Toastr::error(__('invoice.message.warning_last_user'));
            return redirect()->route('invoices.index');
        } else {
            try {
                Invoice::find($id)->delete();
                return back()->with(Toastr::error(__('invoice.message.destroy.success')));
            } catch (Exception $e) {
                $error_msg = Toastr::error(__('invoice.message.destroy.error'));
                return redirect()->route('invoices.index')->with($error_msg);
            }
        }
    }


    public function syncBuyTransactions(Request $request)
    {
       
    }


}
