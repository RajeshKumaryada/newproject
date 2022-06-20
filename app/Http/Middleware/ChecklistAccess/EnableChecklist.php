<?php

namespace App\Http\Middleware\ChecklistAccess;

use App\Classes\Checklist\ChecklistForUsers;
use App\Classes\TrackSession;
use Closure;


class EnableChecklist
{

  public function handle($request, Closure $next)
  {

    $checklist = ChecklistForUsers::init()->find(TrackSession::get()->userId());


    //if list is empty continue with request
    if ($checklist->isEmpty())
      return $next($request);


    //if session is set continue with request
    if ($request->session()->has('checklist_verified')) {

      return $next($request);
    }

    return redirect('checklist/verify');
  }
}
