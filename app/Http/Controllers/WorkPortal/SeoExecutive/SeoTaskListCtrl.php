<?php

namespace App\Http\Controllers\WorkPortal\SeoExecutive;

use App\Http\Controllers\Controller;
use App\Models\SeoTaskList;

class SeoTaskListCtrl extends Controller
{


  /**
   * Fetch Task list for SEO
   * Ex. Bookmarking, Blog Comments, etc.
   */
  public function getList()
  {
    $list = SeoTaskList::orderBy('task', 'ASC')
      ->select('id', 'task as value')
      ->get();

    $return['code'] = 200;
    $return['msg'] = 'success';
    $return['data'] = $list;

    return $return;
  }
}
