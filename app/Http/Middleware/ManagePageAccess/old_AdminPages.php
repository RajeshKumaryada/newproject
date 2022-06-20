<?php

namespace App\Http\Middleware\ManagePageAccess;

use App\Classes\TrackSession;
use Closure;

class AdminPages
{
  public function handle($request, Closure $next)
  {

    $trackSession = TrackSession::getAdmin();

    if (empty($trackSession) || !($trackSession instanceof TrackSession)) {
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
