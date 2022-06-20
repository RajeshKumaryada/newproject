<?php

namespace App\Http\Middleware;

use App\Classes\TrackSession;
use Closure;


/**
 * This class is used for check any user is logged in or not
 * This is top lavel middleware
 */


class AppValidateLogin
{

  public function handle($request, Closure $next)
  {
    if (!TrackSession::has() && !TrackSession::hasAdmin()) {
      return redirect('/');
    }

    return $next($request);
  }
}
