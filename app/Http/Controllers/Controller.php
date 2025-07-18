<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\JoiningHistory;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
    public function sendresponse($status, $message, $data = [])
    {
        return response()->json(['R' => $status, 'M' => $message, 'data' => $data]);
    }

    public function getDownlineUsers($userId){
        $userList = array();
        $results = JoiningHistory::where('for_user_id', $userId)->get();
        if($results){
            foreach($results as $result){
                $userList[] = $result->user_id;
            }
        }
        return $userList;
    }

    public function getDownlineUsersLevelWise($userId){
        $userList = array();
        $results = JoiningHistory::where('for_user_id', $userId)->get();
        if($results){
            foreach($results as $result){
                $userList[$result->level][] = $result->user_id;
            }
        }
        return $userList;
    }

}
