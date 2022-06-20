<?php

namespace App\Http\Controllers\EmployeeManagement;

use App\Http\Controllers\Controller;
use App\Models\EmpDepartment;

class EmpDepartmentCtrl extends Controller
{

  public function allList()
  {
    $list = EmpDepartment::orderBy('dep_name', 'asc')
      ->select('dep_id AS id', 'dep_name as value')
      ->get();

    $return['code'] = 200;
    $return['msg'] = 'success';
    $return['data'] = $list;

    return response()->json($return);
  }
}
