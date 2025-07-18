<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserRequests extends Model
{
    use HasFactory;

    protected $table = 'user_requests';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'user_id',
        'type',
        'meta_data',
        'confirm_key',
        'status',
        'ip_address',
        'created_on',
        'expire_time'
    ];
    
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    

}