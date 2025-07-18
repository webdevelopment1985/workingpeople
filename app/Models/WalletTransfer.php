<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WalletTransfer extends Model
{
    use HasFactory;
    
    protected $table = 'withdraw_amount_history';


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
