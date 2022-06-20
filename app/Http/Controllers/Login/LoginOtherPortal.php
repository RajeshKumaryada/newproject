<?php

namespace App\Http\Controllers\Login;

use App\Classes\Hash as MyHash;
use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\Users;

class LoginOtherPortal extends Controller
{

  /**
   * Login to Leave Portal
   */
  public function leavePortal()
  {

    if (TrackSession::hasAdmin())
      $trackSession = TrackSession::getAdmin();

    else if (TrackSession::has())
      $trackSession = TrackSession::get();


    $user = Users::where('user_id', $trackSession->userId())->where('status', 1)->first();

    if (!empty($user)) {

      $email = $user->email;

      $hash = MyHash::get($email . MyHash::generateRandStr() . time());

      $user->attendance_token = $hash;

      if ($user->save()) {
        return redirect("https://attendance.logelite.com/login-from-portal.php?token={$hash}");
      }
    } else {
      return abort(404, "Invalid authentication. Please contact administration.");
    }
  }



  /**
   * Domain and Hosting
   */
  public function domainHostingPortal()
  {

    $length = rand(15, 25);
    $token = $this->generateRandomString($length) . "|";
    // $time = date("h:i");
    // $token .= $time;
    $token .= time();

    $token = base64_encode($token);

    return redirect("https://domains.logelite.com/?q={$token}");

    // header("Location:https://domains.logelite.com/?q=$token");
  }




  /**
   * Generate Random String
   */
  private function generateRandomString($length)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
}
