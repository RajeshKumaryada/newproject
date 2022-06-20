<?php

namespace App\Http\Controllers\Admin\LoginAsUser;

use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\Users;

class LoginAsUserCtrl extends Controller
{

  /**
   * Function that manage login
   */
  public function login($userId)
  {


    //getting user info
    $users = Users::find($userId);

    if (empty($users)) {
      return "User is not avalable or deleted.";
    }

    $trackSession = new TrackSession();
    $trackSession->userId = $users->user_id;
    $trackSession->userName = $users->username;
    $trackSession->email = $users->email;
    $trackSession->department = $users->department;
    $trackSession->post = $users->post;
    $trackSession->designation = $users->designation;
    $trackSession->createdAt = $users->created_at;


    request()->session()->put(TrackSession::USER_SESSION, serialize($trackSession));


    return redirect(url('') . "/login-success");
  }
}
