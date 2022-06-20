<?php

namespace App\Http\Middleware;

use App\Classes\TrackSession;
use Closure;

/**
 * This is applied on Login and Logout controller
 */

class CheckLoginPageSession
{
  public function handle($request, Closure $next)
  {

    // if ($request->session()->has(TrackSession::USER_SESSION)) {
    if (TrackSession::has() && TrackSession::hasAdmin()) {
      return redirect('/admin/dashboard');
    } else if (TrackSession::has()) {
      return redirect('/login-success');
    } else if (TrackSession::hasAdmin()) {
      return redirect('/admin/dashboard');
    }

    return $next($request);
  }
}
