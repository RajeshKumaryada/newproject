<?php

namespace App\Http\Controllers\EmployeeManagement;

use App\Http\Controllers\Controller;
use App\Models\EmpPost;

class EmpPostCtrl extends Controller
{

  public function allList()
  {
    $list = EmpPost::orderBy('post_name', 'asc')
      ->select('post_id AS id', 'post_name as value')
      ->get();

    $return['code'] = 200;
    $return['msg'] = 'success';
    $return['data'] = $list;

    return response()->json($return);
  }
}
