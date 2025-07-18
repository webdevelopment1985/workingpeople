<?php

namespace App\Models;
use Log;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helper\CryptoAPI;

class Deposit extends Model
{
    use HasFactory;
    
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'updated_on';
    protected $fillable = [
       'transaction_id','txn_type','subtype'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function syncTransactions($type, $currency='USDT')
    {
        
        

        $total_sync = 0;
        if (auth()->check()) {
            $user = auth()->user();
            $CryptoAPI = new CryptoAPI();
            $list_Transactions = (object)array();
            if($type==4) {
                add_user_logs(Auth::user()->id, 'deposit', Auth::user()->username . ' has synced deposit transactions for USDT');
                $subtype='bep20';
                $naration = 'USDT(BEP20) deposited successfully';
                $syncResponse = $CryptoAPI->make_api_call('sync_Transactions', [
                    "Email" => $user->email,
                    "Currency"=>$currency
                ]);

                $logData = [
                    'request'=>[
                        "Email" => $user->email,
                        "Currency"=>$currency
                    ],
                    'response'=>$syncResponse
                ];                
                \Log::info('cryptoResponse:sync_Transactions['.$user->email.']' . json_encode($logData));

                $list_Transactions = $CryptoAPI->make_api_call('list_Transactions', [
                    "Email" => $user->email,
                    "Type"=>$type,
                    "Take"=>"20",
                    "Skip"=>"0"
                ]);

                $logData = [
                    'request'=>[
                        "Email" => $user->email,
                        "Currency"=>$currency
                    ],
                    'response'=>$list_Transactions
                ];                
                \Log::info('cryptoResponse:list_Transactions['.$user->email.']' . json_encode($logData));
            }
            if(isset($list_Transactions->count) && $list_Transactions->message = "success" && $list_Transactions->count) {
                foreach($list_Transactions->data as $js) {

                    $js = (array)$js;
                    
                    if($js['hash']) {
                        
                        $hash = $js['hash'];
                        
                        $check_txid = Deposit::where('txid', $hash)->first();
                  
                        if(!$check_txid) {
                            $deposit = new Deposit;
                            $deposit->amount = $js['amount'];
                            $deposit->user_id = $user->id;
                            $deposit->transaction_id = 'R-'.rand(100000, 999999);
                            $deposit->txn_type = 'deposit';
                            $deposit->subtype = $subtype;
                            $deposit->currency = $currency;
                            $deposit->status = 1;
                            $deposit->naration = $naration;
                            $deposit->txid = $hash;
                            if(isset($js['senderAddress']) && $js['senderAddress'] !='') {
                                $deposit->from_address = $js['senderAddress'];
                            }
                            if(isset($js['recieverAddress']) && $js['recieverAddress'] !='') {
                                $deposit->to_address = $js['recieverAddress'];
                            }
                            $deposit->save();
                            $lastInsertedId = $deposit->id;
                            $total_sync++;
                            if($lastInsertedId){
                                $transaction = (new Transaction())->updateUserBalance($user->id, $js['amount'], 0, 'USDT', $naration, 'credit', 'deposit', 1, $lastInsertedId, $hash);
                            }
                        }
                    }
                }
            }
        }

        if($type==4) {
            add_user_logs(Auth::user()->id, 'deposit', $total_sync . ' transactions synced for USDT');
        }
        return $total_sync;
    }
}