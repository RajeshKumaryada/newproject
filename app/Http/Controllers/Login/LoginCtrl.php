<?php

namespace App\Http\Controllers\Login;

use App\Classes\Log\Log4UserLogin;
use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\LoginLocation;
use App\Models\Users;
use App\Models\UsersAlam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginCtrl extends Controller
{

  public function index()
  {
    return view('login.login');
  }


  public function authLogin(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'work_from' => "required",
        'username' => "required|alpha_dash",
        'password' => "required",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }
    $workFrom = $request->input('work_from');
    $username = ($request->input('username'));

    $users = Users::where('username', $username)
      ->where('status', 1)
      ->first(); 

    // print_r($users);

    if (empty($users)) {

      $return['code'] = 101;
      $return['msg'] = 'Username is invalid or not registered!';

      return response()->json($return);
    }

    $password = $request->input('password');
    //dd($password);
    // $users->password;

    if (Hash::check($password, $users->password)) {

      $trackSession = new TrackSession();
      $trackSession->userId = $users->user_id;
      $trackSession->userName = $users->username;
      $trackSession->email = $users->email;
      $trackSession->department = $users->department;
      $trackSession->post = $users->post;
      $trackSession->designation = $users->designation;
      $trackSession->createdAt = $users->created_at;

      $local_user = LoginLocation::where('user_id',$users->user_id)->whereDate('date',date('Y-m-d'))->first();
      // dd($local_user->location);
      $local_admin = LoginLocation::where('user_id','1')->whereDate('date',date('Y-m-d'))->first();
      //checking user is admin or not
      //7 means admin
      if ($users->post === 7) {
        $request->session()->put(TrackSession::ADMIN_SESSION, serialize($trackSession));

        if(empty($local_admin)){
          
          $wl = new LoginLocation();
          $wl->user_id = 1;
          $wl->location = $workFrom;
          $wl->date = date('Y-m-d H:i:s');
          $wl->save();
      }

        $return['code'] = 200;
        $return['msg'] = 'Login Successfully.';
        $return['url'] = url('') . "/admin/dashboard";
      }
      //normal user
      else {
        $request->session()->put(TrackSession::USER_SESSION, serialize($trackSession));

        if(empty($local_user)){
              
          $wl = new LoginLocation();
          $wl->user_id = $users->user_id;
          $wl->location = $workFrom;
          $wl->date = date('Y-m-d H:i:s');
          $wl->save();
      }
      // dd($local_user->location);
      // 1 is office,2 in home
        if($workFrom == 1){
          $alarms =  UsersAlam::where('user_id',$users->user_id)->first();
          if(!empty($alarms)){
            $alarms->status = 2;
            $alarms->save();
          }
       }else if($workFrom == 2){
         $alarms =  UsersAlam::where('user_id',$users->user_id)->first();
         if(!empty($alarms)){
          $alarms->status = 1;
          $alarms->save();
         }
       }
      

        $return['code'] = 200;
        $return['msg'] = 'Login Successfully.';
        $return['url'] = url('') . "/login-success";
      }

  




      Log4UserLogin::init()->event('login')->info('login success - ' . $users->username)->save($users->user_id);

      return response()->json($return);
    } else {


      // Log4UserLogin::init()->event('login')->info('password missmatched')->save();

      $return['code'] = 101;
      $return['msg'] = 'Password missmatched!';

      return response()->json($return);
    }
  }
}
