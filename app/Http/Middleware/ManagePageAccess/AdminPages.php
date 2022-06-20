<?php

namespace App\Http\Middleware\ManagePageAccess;

use App\Classes\CheckUserAccess;
use App\Classes\TrackSession;
use Closure;
use Illuminate\Support\Facades\Request;

class AdminPages
{
  public function handle($request, Closure $next)
  {

    $trackSession = TrackSession::getAdmin();

    if (empty($trackSession) || !($trackSession instanceof TrackSession)) {
      return abort(404);
    }

    //check for user as admin
    if (!empty($trackSession->userAsAdmin)) {

      //getting current page
      $crrPageArr = (explode('/', str_replace(url('') . '/', '', Request::url())));

      if ((Request::isMethod('post') || Request::isMethod('get')) && $crrPageArr[0] === 'ajax') {
        return $next($request);
      }

      $isValid =  CheckUserAccess::check($trackSession->userId(), $crrPageArr);
      if ($isValid === true) {
        return $next($request);
      }



      return abort(404);
    }

    switch ($trackSession->postId()) {
      case 7:
        //AdminPages
        return $next($request);
        break;
    }

    return abort(404);
  }
}
