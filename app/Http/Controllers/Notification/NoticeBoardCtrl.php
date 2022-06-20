<?php

namespace App\Http\Controllers\Notification;


use App\Http\Controllers\Controller;
use App\Models\Options;

class NoticeBoardCtrl extends Controller
{


  /**
   * AJAX call
   * GET method
   */
  public function fetchNotice()
  {


    $notice = Options::where('opt_key', 'notice_board_msg')->first();


    if (empty($notice)) {
      $msg = '';
    } else {
      $msg = $notice->opt_value;
    }

    $return['code'] = 200;
    $return['msg'] = $msg;

    return response()->json($return);
  }
}
