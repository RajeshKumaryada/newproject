<?php

namespace App\Http\Controllers\UserProfile;

use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileManagerCtrl extends Controller
{


  /**
   * Change password for user
   */
  public function changePassword(Request $request)
  {

    $user = Users::find(TrackSession::get()->userId());


    $validator = Validator::make(
      $request->all(),
      [
        'old_password' => ['required', 'min:6', 'max:50', new MatchOldPassword($user->password)],
        'password' => "required|confirmed|min:6|max:50"
      ]
    );


    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }



    if (strcmp($request->input('old_password'), $request->input('password')) === 0) {
      $return['code'] = 101;
      $return['msg'] = 'Old and New passwords are same.';

      return response()->json($return);
    }


    $user->password = Hash::make($request->input('password'));

    if ($user->save()) {
      $return['code'] = 200;
      $return['msg'] = 'Password changed successfully.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }



  /**
   * Change password for Admin
   */
  public function changePasswordAdmin(Request $request)
  {

    $user = Users::find(TrackSession::getAdmin()->userId());


    $validator = Validator::make(
      $request->all(),
      [
        'old_password' => ['required', 'min:6', 'max:50', new MatchOldPassword($user->password)],
        'password' => "required|confirmed|min:6|max:50"
      ]
    );


    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }



    if (strcmp($request->input('old_password'), $request->input('password')) === 0) {
      $return['code'] = 101;
      $return['msg'] = 'Old and New passwords are same.';

      return response()->json($return);
    }


    $user->password = Hash::make($request->input('password'));

    if ($user->save()) {
      $return['code'] = 200;
      $return['msg'] = 'Password changed successfully.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }
}
