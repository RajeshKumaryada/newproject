<?php

namespace App\Http\Controllers\WorkPortal\Developer;


use App\Http\Controllers\Controller;

class DeveloperCtrl extends Controller
{

  public function index()
  {
    return view('work_portal.developer.index');
  }
}
