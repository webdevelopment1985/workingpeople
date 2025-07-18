<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Setting;
use DataTables;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

// use App\Models\Transactions;

class SettingController extends Controller
{
   
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Setting::where('status', 1)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // "'.route('settings.edit', $row->id).'"
                    $edit = '<a href="javascript:void(0);" onclick="editSettings('.$row->id.','.$row->meta_value.');" class="custom-edit-btn mr-1">
                                    <i class="fe fe-pencil"></i>
                                        '.__('default.form.edit-button').'
                                </a>';
                   
                    // $delete = '<button class="custom-delete-btn remove-user" data-id="'.$row->id.'" data-action="'.route('settings.destroy').'">
                    // 				<i class="fe fe-trash"></i>
                    //                 '.__('default.form.delete-button').'
                    // 			</button>';
                    
                    $action = $edit; //.' '.$delete;
                    return $action;
                })

                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        $current_status = 'Checked';
                    } else {
                        $current_status = '';
                    }
                    $status = "
                            <input type='checkbox' id='status_$row->id' id='user-$row->id' class='check' onclick='changeSettingStatus(event.target, $row->id);' " .$current_status. ">
							<label for='status_$row->id' class='checktoggle'>checkbox</label>
                    ";
                    return $status;
                })

                ->addColumn('meta_key', function ($row) {
                    return ucfirst(str_replace("_", " ", $row->meta_key));
                })
                ->addColumn('meta_value', function ($row) {
                    return $row->meta_value;
                })

                // ->addColumn('is_verified', function($row){
                // 	if ($row->is_verified == 1) {
                // 		$is_verified = 'Yes';
                // 	}else{
                // 		$is_verified = 'No';
                // 	}
                   
                //     return $is_verified;
                // })

                // ->editColumn('created_at', '{{date("jS M Y", strtotime($created_at))}}')
                // ->editColumn('updated_at', '{{date("jS M Y", strtotime($updated_at))}}')
                ->escapeColumns([])
                ->make(true);
        }
        return view('admin.settings.index');
    }



    public function status_update(Request $request)
    {
        $setting = Setting::find($request->id)->update(['status' => $request->status]);
        // pr(Setting::find($request->id));
        if($request->status == 1) {
            return response()->json(['message' => 'Status activated successfully.']);
        } else {
            return response()->json(['message' => 'Status deactivated successfully.']);
        }
    }

    public function create()
    {
        return view('admin.settings.create');
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
            $setting = Setting::create($input);
            Toastr::success(__('setting.message.store.success'));
            return redirect()->route('settings.index');

        } catch (Exception $e) {
            Toastr::error(__('setting.message.store.error'));
            return redirect()->route('settings.index');
        }
    }

    public function edit($id)
    {
        $setting = Setting::find($id);
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $getvalue = Setting::find($request->id);

        $setting = Setting::find($request->id)->update(['meta_value' => $request->val,'updated_at'=>date('Y-m-d h:i:s')]);

        if($setting){
            $old_value = $getvalue->meta_value;
            $meta_key = $getvalue->meta_key;
            $userId = Auth::id();
            add_admin_logs($userId,'setting',"Setting for $meta_key changed from $old_value to $request->val");
            return response()->json(['status'=>true,'message' => 'Setting Update successfully.']);
        }else{
            return response()->json(['status'=>false,'message' => 'Setting Not Updated.']);
        }
        // die('Not Allowed');

        // $rules = [
        //     'meta_key' 			=> 'required',
        //     'meta_value' 		=> 'required',
        // ];

        // $messages = [
        //     'meta_key.required'    		=> __('default.form.validation.name.required'),
        //     'meta_value.required'    	=> __('default.form.validation.email.required'),
        // ];
        
        // $this->validate($request, $rules, $messages);
        // $input = $request->all();
        // $setting = Setting::find($id);
        // try {
        //     $setting->update($input);
        //     Toastr::success(__('setting.message.update.success'));
        //     return redirect()->route('settings.index');
        // } catch (Exception $e) {
        //     Toastr::error(__('setting.message.update.error'));
        //     return redirect()->route('settings.index');
        // }
    }

    public function destroy()
    {
        $id = request()->input('id');
        $all_setting = Setting::all();
        $count_all_setting = $all_user->count();

        if ($count_all_setting <= 1) {
            Toastr::error(__('setting.message.warning_last_user'));
            return redirect()->route('settings.index');
        } else {
            try {
                Setting::find($id)->delete();
                return back()->with(Toastr::error(__('setting.message.destroy.success')));
            } catch (Exception $e) {
                $error_msg = Toastr::error(__('setting.message.destroy.error'));
                return redirect()->route('settings.index')->with($error_msg);
            }
        }
    }


}
