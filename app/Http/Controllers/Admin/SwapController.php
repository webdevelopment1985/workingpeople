<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Admin;

use App\Helper\CryptoAPI;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Swap;
use DataTables;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

// use App\Models\Transactions;

class SwapController extends Controller
{
    private $cryptoAPI;

    public function __construct()
    {
        $this->cryptoAPI = new CryptoAPI();
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $skip = isset($request->start) ? $request->start : 0;
            $take = isset($request->length)? $request->length : 10;

            if (isset($request->status)) {
                $data = Swap::where('amount', '!=', '');

                if (isset($request->search['value']) && $request->search['value'] != '') {
                    $search =  $request->search['value'];
                    $data = $data->where('txid', 'like', '%' . $search . '%')->orWhereHas('user', function ($query) use ($search) {
                        $query->where('email', 'like', '%' . $search . '%');
                    });
                }

                $data = $data->where('status', $request->status)->orderBy('added', 'desc')->skip($skip)->take($take)->get();
                if (isset($request->search['value']) && $request->search['value'] != '') {
                    $count = $data->count();
                } else {
                    $count = Swap::where('status', $request->status)->get()->count();
                }
            }
            //else {
            //     $data = Swap::get();
            //     $count = Swap::get()->count();
            // }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $accept = '<button class="custom-create-btn remove-user"  data-id="'.$row->id.'" onclick="changeSwapStatus(event.target, '.$row->id.',1);" >
                        <i class="fe fe-correct"></i>
                        '.__('Accept').'
                    </button>';

                    $reject = '<button class="custom-delete-btn disable" onclick="changeSwapStatus(event.target, '.$row->id.',2);" data-id="'.$row->id.'">
										<i class="fe fe-disabled"></i>
		                                '.__('Reject').'
									</button>';
                
                    $action = '';
                    if($row->status ==0) {
                        $action = $accept.' '.$reject;
                    } elseif($row->status==1) {
                        $action= "Approved";
                    } elseif($row->status==2) {
                        $action= "Rejected";
                    }
                    return $action;
                })
                ->addColumn('user_name', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('email', function ($row) {
                    return $row->user->email;
                })
                ->addColumn('view_address', function ($row) {
                    $view_old_add = '<button class="custom-create-btn remove-user" onclick="viewTransId(event.target, '.$row->user_id.');" data-id="'.$row->id.'">
                    <i class="fe fe-correct"></i>
                    '.__('Ubit Address').'
                </button>';
                    return $view_old_add;
                })
                ->addColumn('txid', function ($row) {
                    $shortenTransactionID = shortenTransactionID($row->txid, 10);
                    $txnHashHtml = '-';
                    if($row->txid) {
                        $anchorLink = "https://ubitscan.io/tx/".$row->txid;
                        $txnHashHtml = "<a href='".$anchorLink."' target='_blank' title=".$row->txid.">".$shortenTransactionID."</a>";
                    }
                    return $txnHashHtml;
                })
                ->addColumn('payment_id', function ($row) {
                    $shortenTransactionID = shortenTransactionID($row->payment_id, 10);
                    $txnHashHtml = '-';
                    if($row->payment_id) {
                        $txnHashHtml = "<span title=".$row->payment_id.">".$shortenTransactionID."</span>";
                    }
                    return $txnHashHtml;
                })
                ->editColumn('added', '{{date("jS M Y H:i:s", strtotime($updated))}}')
                ->escapeColumns([])
                ->skipTotalRecords($count)
                ->setTotalRecords($count)
                ->setFilteredRecords($count)
                ->skipPaging()
                ->make(true);
        }
        return view('admin.swap.index');
    }

    public function request(Request $request)
    {
        return view('admin.swap.request');
    }

    public function edit($id)
    {
        $swap = Swap::find($id);
        $roles = Role::all();
        return view('admin.swap.edit', compact('swap', 'roles'));
    }

    public function status_update(Request $request)
    {
        
    }

    public function export_csv()
    {
        // $swapdata = Swap::get();
        // $csvFileName = 'swap_report.csv';
        // $headers = [
        //     'Content-Type' => 'text/csv',
        //     'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        // ];

        // $handle = fopen('php://output', 'w');
        // fputcsv($handle, [
        //     'User Name',
        //     'Email',
        //     'Payment ID',
        //     'Recieve address',
        //     'Amount',
        //     'Txid',
        //     'Status',
        //     'Added'
        // ]);

        // foreach ($swapdata as $data) {
        //     $user = Users::where(["id"=>$data->user_id])->first();
        //     $status='';
        //     if($data->status==0) {
        //         $status= "Pending";
        //     } elseif($data->status==1) {
        //         $status= "Approved";
        //     } elseif($data->status==2) {
        //         $status= "Rejected";
        //     }
        //     fputcsv($handle, [
        //             $user->name,
        //             $user->email,
        //             $data->payment_id,
        //             $data->rec_address,
        //             $data->amount,
        //             $data->txid,
        //             $status,
        //             $data->added,
        //     ]);
        // }

        // fclose($handle);

        // return Response::make('', 200, $headers);
        
    }
    

    public function view_transid(Request $request)
    {
        if ($request->ajax()) {
            $data = array();
            $user = Users::find($request->id);
            if($user) {
                try {
                    $apiResponse = $this->cryptoAPI->make_api_call('get_Account', [
                        "Email" => $user->email
                    ]);
                    $status = false;
                    $data['address'] = '';
                    $message = '';
                    if(isset($apiResponse->message) && $apiResponse->message == 'success' && $apiResponse->oldAddress != '') {
                        $status = true;
                        $data['address'] = $apiResponse->oldAddress;
                        $message = 'Address found';
                    } else {
                        $message = 'Address not found';
                    }
                    return response()->json(['status' => $status, 'message'=>$message, 'data'=>$data]);
                } catch(Exception $e) {
                    return response()->json(['status' => false, 'message'=>'Server did not response. Please try after sometimes', 'data'=>[]]);
                }
            } else {
                return response()->json(['status' => false, 'message'=>'User does not exist', 'data'=>$data]);
            }
        }
        return response()->json(['status' => false, 'message'=>'Invalid request', 'data'=>[]]);
    }



}
