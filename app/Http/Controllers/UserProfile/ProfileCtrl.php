<?php

namespace App\Http\Controllers\UserProfile;

use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\Users;


class ProfileCtrl extends Controller
{


  /**
   * View for User profile
   */
  public function viewProfile()
  {
    //finding and getting user info
    $user = Users::find(TrackSession::get()->userId());

    return view('user_profile.view_profile', ['user' => $user]);
  }



  /**
   * View for User Change Password
   */
  public function viewChangePassword()
  {
    return view('user_profile.change_password');
  }



  /**
   * View for User profile
   */
  public function viewAdminProfile()
  {
    //finding and getting user info
    $user = Users::find(TrackSession::getAdmin()->userId());

    return view('user_profile.view_profile_admin', ['user' => $user]);
  }



  /**
   * View for User Change Password
   */
  public function viewAdminChangePassword()
  {
    return view('user_profile.change_password_admin');
  }
}
