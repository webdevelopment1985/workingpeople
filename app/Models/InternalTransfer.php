<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalTransfer extends Model
{
    use HasFactory;

    protected $table = 'internal_transfer';

    protected $fillable = [
        'transactionId',
        'from_user',
        'to_user',
        'amount',
        'confirm_key',
        'ip_address',
        'status',
        'otp',
        'otp_expire_time',
        'created_at'
    ];

    public $timestamps = false;


    /**
     * Get the user who sent the transfer.
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user');
    }

    /**
     * Get the user who received the transfer.
     */
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user');
    }


}
