<?php

namespace App\Http\Middleware\ManagePageAccess;

use App\Classes\TrackSession;
use Closure;

class ContentWriterPages
{
  public function handle($request, Closure $next)
  {

    $trackSession = TrackSession::get();

    if (empty($trackSession) || !($trackSession instanceof TrackSession)) {
      return abort(404);
    }

    switch ($trackSession->postId()) {
      case 1:
        //ContentWriter
        return $next($request);
        break;
    }

    return abort(404);
  }
}
