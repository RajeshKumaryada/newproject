<?php

namespace App\Http\Controllers\Login;

use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\LoginLocation;
use Illuminate\Http\Request;

class UserLoginLocationCtrl extends Controller
{
    /**
     * Fetch Location
     */
    public function getLocate()
    {
        $user_id = TrackSession::get()->userId();
        $data = LoginLocation::where('user_id',$user_id)->where('location','2')->first();

        if($data){
            $return['code'] = 200;
            $return['msg'] = "Location Found";
            $return['data'] = $data;
        }else{
            $return['code'] = 101;
            $return['msg'] = "Location Not Found";
        }
        return response()->json($return);
    }
}
