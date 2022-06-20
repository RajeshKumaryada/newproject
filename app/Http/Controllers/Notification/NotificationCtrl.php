<?php

namespace App\Http\Controllers\Notification;

use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\NotificationsLastSeen;
use App\Models\NotificationsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationCtrl extends Controller
{


  /**
   * View for notification list for user
   */
  public function viewListForUser()
  {
    return view('notification.list_for_user');
  }



  /**
   * AJAX Call
   * GET Method
   * Fetch All Notifications for user
   */
  public function fetchListForUser()
  {

    $trackSession = TrackSession::get();

    $noti = NotificationsUsers::with(['notifications'])
      ->whereDate('date', '>=', $trackSession->createdAt())
      // ->where('user_id', $trackSession->userId())
      // ->orWhere('user_id', 0)
      ->where(function ($sql) {
        return $sql->where('user_id', TrackSession::get()->userId())
          ->orWhere('user_id', 0);
      })
      ->orderBy('date', 'DESC')
      ->get();


    if (empty($noti)) {
      $return['code'] = 200;
      $return['data'] = [];
      $return['last_seen'] = 0;

      return response()->json($return);
    }


    //getting last seen message id
    $lastSeen = $this->getLastSeen();


    $return['code'] = 200;
    $return['data'] = $noti;
    $return['last_seen'] = $lastSeen;
    $return['last_id'] = $noti[0]->notification_id;

    return response()->json($return);
  }



  /**
   * AJAX Call
   * GET Method
   * Check New Notification for user
   */
  public function checkForUser()
  {

    $trackSession = TrackSession::get();
    $lastSeen = $this->getLastSeen();

    $date = null;
    $noti_count = NotificationsUsers::where('notification_id', '>', $lastSeen)
      ->whereDate('date', '>=', $trackSession->createdAt())
      ->where(function ($sql) {
        return $sql->where('user_id', TrackSession::get()->userId())
          ->orWhere('user_id', 0);
      })
      ->count();


    if ($noti_count > 0) {
      $date = NotificationsUsers::select('date')->where('user_id', $trackSession->userId())
        ->orWhere('user_id', 0)
        ->orderBy('date', 'DESC')->first();

      $date = $date->date;

      $date1 = date_create($date);
      $date2 = date_create(date('Y-m-d'));
      $dateDiff = date_diff($date1, $date2);
      $date = $dateDiff->format("%a");

      if ($date === '0') {
        $date = 'Today';
      } elseif ($date === '1') {
        $date = 'Yesterday';
      } else {
        $date .= ' Days';
      }
    }



    $data = [
      'new' => $noti_count,
      'date' => $date
    ];


    $return['code'] = 200;
    $return['data'] = $data;
    return response()->json($return);
  }



  /**
   * AJAX call
   * POST method
   * Update Last seen notification id to last seen table
   */
  public function updateLastSeenNotification(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'last_id' => "required|numeric|max:9999999999"
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors()->get('last_id');

      return response()->json($return);
    }

    $lastSeen = NotificationsLastSeen::where('user_id', TrackSession::get()->userId())->first();

    if (empty($lastSeen)) {
      $lastSeen = new NotificationsLastSeen();
      $lastSeen->user_id = TrackSession::get()->userId();
    }

    $lastSeen->notification_id = $request->input('last_id');
    //$lastSeen->user_id = TrackSession::get()->userId();
    $lastSeen->seen_date = date('Y-m-d H:i:s');

    if ($lastSeen->save()) {
      $return['code'] = 200;
    } else {
      $return['code'] = 101;
    }

    return response()->json($return);
  }



  /**
   * getting last seen notification ID
   */
  private function getLastSeen(): int
  {
    //getting last seen message id
    $lastSeen = NotificationsLastSeen::select('notification_id')
      ->where('user_id', TrackSession::get()->userId())
      ->first();

    if (empty($lastSeen)) {
      return 0;
    } else {
      return $lastSeen->notification_id;
    }
  }
}
