<?php

namespace App\Http\Controllers\EmployeeManagement;

use App\Http\Controllers\Controller;
use App\Models\EmpDesignation;

class EmpDesignationCtrl extends Controller
{

  public function allList()
  {
    $list = EmpDesignation::orderBy('des_name', 'asc')
      ->select('des_id AS id', 'des_name as value')
      ->get();

    $return['code'] = 200;
    $return['msg'] = 'success';
    $return['data'] = $list;

    return response()->json($return);
  }
}
