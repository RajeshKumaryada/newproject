<?php

namespace App\Http\Controllers\WorkPortal\Designer;


use App\Http\Controllers\Controller;

class DesignerCtrl extends Controller
{

  public function index()
  {
    return view('work_portal.designer.index');
  }
}
