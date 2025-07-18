<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Phases extends Model
{
    use HasFactory;
    protected $table = 'tbl_phases';

     // Retrieve the active phase based on conditions
     public static function getActivePhase()
     {
        //  $totalTokens = DB::table('invoices');
 
        //  return self::where(function ($query) use ($totalTokens) {
        //      $query->where('token_issued', 2000000)->where(DB::raw($totalTokens), '<=', 2000000)
        //          ->orWhere('token_issued', 3000000)->where(DB::raw($totalTokens), '>=', 2000000)->where(DB::raw($totalTokens), '<', 500000)
        //          ->orWhere('token_issued', 4000000)->where(DB::raw($totalTokens), '>=', 5000000)->where(DB::raw($totalTokens), '<', 900000)
        //          ->orWhere('token_issued', 5000000)->where(DB::raw($totalTokens), '>=', 9000000)->where(DB::raw($totalTokens), '<=', 1400000)
        //          ->orWhere('token_issued', 6000000);
        //  })->first();
     }

}