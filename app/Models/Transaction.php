<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';


    // Specify the fields that are mass assignable
    protected $fillable = [
        'user_id',
        'currency',
        'reference_id',
        'narration',
        'type',
        'trans_type',
        'amount',
        'fee',
        'txid',
        'uniqueId',
        'address',
        'ip',
        'status',
        'created_at',
        'updated_at'
    ];
    
    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function updateUserBalance($userId, $amount, $fee, $currency, $narration, $type, $trans_type, $status = 0, $referenceId = null, $txid = null)
    {
        $user = User::find($userId);
        if (!$user) {
            return false;
        }
    
        $transTypeList = array('withdraw', 'roi-income', 'level-income');
        if(in_array($trans_type, $transTypeList)){
            $amountField = 'withdrawable_amount';
        }
        else{
            $amountField = 'wallet_amount';
        }
    
        if ($type == 'debit' && $user->$amountField < $amount) {
            return false;
        }
    
        if ($type == 'credit') {
            $user->$amountField += $amount;
        } elseif ($type == 'debit') {
            $user->$amountField -= $amount;
        } else {
            return false;
        }
        $user->save();
    
        return self::create([
            'user_id'      => $userId,
            'currency'     => $currency,
            'reference_id' => $referenceId ?? 0,
            'narration'    => $narration,
            'type'         => $type,
            'trans_type'   => $trans_type,
            'amount'       => $amount,
            'fee'          => $fee,
            'status'       => $status,
            'txid'         => $txid,
            'ip'           => request()->ip(),
        ]);
        
    }

    public function adminTotalIncome($type, $currency='USDT'){
        return Transaction::where('status',1)->where('type', 'credit')->where('trans_type', $type)->where('currency', $currency)->sum('amount');
    }
}