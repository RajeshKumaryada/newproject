<?php

namespace App\Http\Controllers\Login;

use App\Classes\Log\Log4UserLogin;
use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutCtrl extends Controller
{
  public function index(Request $request)
  {

    if (TrackSession::has()) {
      $ts = TrackSession::get();

      Log4UserLogin::init()->event('logout')->info('logout success - ' . $ts->userName())->save($ts->userId());
    } elseif (TrackSession::hasAdmin()) {
      $ts = TrackSession::getAdmin();

      Log4UserLogin::init()->event('logout')->info('logout success - ' . $ts->userName())->save($ts->userId());
    }





    $request->session()->flush();



    return redirect("/");
  }
}
