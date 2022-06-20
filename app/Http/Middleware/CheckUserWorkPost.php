<?php

namespace App\Http\Middleware;

use App\Classes\TrackSession;
use Closure;

class CheckUserWorkPost
{
  public function handle($request, Closure $next)
  {

    $trackSession = TrackSession::get();

    switch ($trackSession->postId()) {
      case 1:
        //content writer
        return redirect('/content-writer');
        break;
      case 2:
        //designer
        return redirect('/designer');
        break;
      case 3:
        //developer
        return redirect('/developer');
        break;
      case 4:
        //seo
        return redirect('/seo');
        break;
      case 5:
        //hr
        return redirect('/human-resource');
        break;
      case 6:
        //manager
        break;
        // case 7:
        //   //admin
        //   return redirect('/admin/dashboard');
        //   break;

      case 8:
        //Back Office
        return redirect('/back-office');
        break;
    }

    return abort(404);
    // return $next($request);
    //return "On the way...";
  }
}
