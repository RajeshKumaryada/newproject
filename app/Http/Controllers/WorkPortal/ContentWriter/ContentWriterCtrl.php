<?php

namespace App\Http\Controllers\WorkPortal\ContentWriter;


use App\Http\Controllers\Controller;

class ContentWriterCtrl extends Controller
{

  public function index()
  {
    return view('work_portal.content_writer.index');
  }
}
