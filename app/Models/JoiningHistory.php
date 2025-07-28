<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class JoiningHistory extends Model
{
    // Specify the table if it's different from the model name
    protected $table = 'joining_history';

    // Specify the primary key (optional, as Laravel uses 'id' by default)
    protected $primaryKey = 'id';

    // If the table doesn't have timestamps (created_at, updated_at), disable them
    public $timestamps = false;

    // Specify the fillable fields to allow mass assignment
    protected $fillable = ['level', 'user_id', 'parent_user_id', 'tree_id', 'paid'];

    // Define the relationship to the User model
    public function forUser()
    {
        return $this->belongsTo(User::class, 'parent_user_id', 'id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
