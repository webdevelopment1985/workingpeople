<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Helper\CryptoAPI;
use Illuminate\Support\Facades\Auth;
use App\Models\InternalTransfer;
use App\Models\Packages;
use App\Models\Invoice;
use App\Models\JoiningHistory;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'uuid',
        'sponsor',
        'users_type',
        'status',
        'is_paid',
        'mobile',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin()
    {
        if (Auth::user()->users_type == 2) {
            return true;
        }
        return false;
    }



    public function getSriAddress()
    {
        $address = '';
        return $address;
    }

    public function getOldAddress()
    {
        $address = '';
        return $address;
    }

    public function getUsdtAddress()
    {
        $address = '';
        if (!empty($this->email)) {
            $CryptoAPI = new CryptoAPI();
            $responseAccnt = $CryptoAPI->make_api_call('get_Account', [
                "Email" => $this->email,
                "Currency" => "USDT"
            ]);
            if (isset($responseAccnt->message) && $responseAccnt->message == 'success') {
                $address = $responseAccnt->usdtAddress ?? '';
            }
        }
        return $address;
    }

    public function getWithdrawBalance()
    {
        $balance = 0;
        if (!empty($this->email)) {
            $CryptoAPI = new CryptoAPI();
            $apiResponse = $CryptoAPI->make_api_call('get_Balance', [
                "Email" => $this->email,
            ]);
            $symbol = 'USDT';
            // dd( $apiResponse);
            if ($apiResponse->message == 'success' && $apiResponse->wBalance) {
                $wbalance = $apiResponse->wBalance;

                $filteredItems = array_filter($wbalance, function ($item) use ($symbol) {

                    return $item->currrency == $symbol;
                });

                $balance = array_values($filteredItems)[0]->balance ?? 0;
            }
        }
        return $balance;
    }

    public function getBalance($type)
    {
        $balance = 0;
        switch (strtolower($type)) {
            case 'usdt':
                $balance = Auth::user()->wallet_amount;
                break;
            case 'withdrawable_amount':
                $balance = Auth::user()->withdrawable_amount;
                break;
            default:
                $balance = 0;
                break;
        }
        return $balance;
    }


    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function totalDepositByCurrency($currency)
    {
        return $this->deposits()->where('status', 1)->where('currency', $currency)->sum('amount');
    }

    public function totalPurchase()
    {
        return $this->invoices()->where('status', 1)->sum('amount');
    }

    public function totalIncome($type)
    {
        return $this->transactions()->where('status', 1)->where('type', 'credit')->where('trans_type', $type)->sum('amount');
    }

    public function referralLink()
    {
        return route('register', ['sponsor' => Auth::user()->username]);
    }

    public function swaps()
    {
        // return $this->hasMany(Swap::class, 'user_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'user_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function packages()
    {
        return $this->hasMany(Packages::class, 'user_id');
    }

    public function userRequests()
    {
        return $this->hasMany(UserRequests::class, 'user_id');
    }

    public function withdrawRequest($confirmKey, $status)
    {
        return $this->userRequests()->where('status', $status)->where('confirm_key', $confirmKey)->get();
    }

    public function sentTransfers()
    {
        return $this->hasMany(InternalTransfer::class, 'from_user');
    }

    public function receivedTransfers()
    {
        return $this->hasMany(InternalTransfer::class, 'to_user');
    }

    public function myDownlineUsers()
    {
        return $this->hasMany(JoiningHistory::class, 'parent_user_id', 'id');
    }
}
