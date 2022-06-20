<?php

namespace App\Http\Controllers\WorkPortal\HumanResource;


use App\Http\Controllers\Controller;

class HumanResourceCtrl extends Controller
{

  public function index()
  {
    return view('work_portal.human_resource.index');
  }
}
