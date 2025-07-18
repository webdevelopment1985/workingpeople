<?php

namespace App\Models;

use App\Models\User;

use App\Helper\CryptoAPI;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Swap extends Model
{
    use HasFactory;
    const CREATED_AT = "added";
    const UPDATED_AT = "updated";
    protected $fillable = [
        'method',
        'user_id',
        'rec_address',
        'payment_id',
        'payment_address',
        'amount',
        'amount_usdt',
        'fees',
        'price',
        'added',
        'updated',
        'ip',
        'txid',
        'status',
        'token_done',
        'is_paid',
        'show_flag',
        'method',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function syncTransactions($TransactionRequestId)
    {

       
    
    }

    

}
