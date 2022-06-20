<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Variables\WorkTeamType;
use App\Http\Controllers\Controller;
use App\Models\EmpPost;
use App\Models\Notifications;
use App\Models\NotificationsUsers;
use App\Models\Users;
use App\Models\WorkTeamInfo;
use App\Models\WorkTeamMembers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class NotificationCtrl extends Controller
{


  /**
   * View for create notification
   */
  public function viewCreate()
  {

    $teamType = WorkTeamType::get();

    $userGroups = [
      'groups' => ['all' => 'All Employees']
    ];


    //getting all posts
    //exclude admin, manager post
    $posts = EmpPost::select('post_id', 'post_name')
      ->whereNotIn('post_id', [6, 7])
      ->orderBy('post_name', 'asc')
      ->get();

    foreach ($posts as $row) {
      $userGroups['posts']['post#' . $row->post_id] = ucwords($row->post_name);
    }


    //getting all teams
    $teams = WorkTeamInfo::select('wt_id', 'team_name', 'team_type')
      ->orderBy('team_type', 'asc')
      ->orderBy('team_name', 'asc')
      ->get();

    foreach ($teams as $row) {
      $userGroups['teams']['team#' . $row->wt_id] = $teamType->value($row->team_type) . ' - ' . ucwords($row->team_name);
    }


    //getting all individual user
    $users = Users::select('user_id', 'username', 'post')
      ->where('status', 1)
      ->whereNotIn('username', ['admin'])
      ->orderBy('username', 'asc')
      ->get();

    foreach ($users as $row) {
      $userGroups['users'][$row->user_id] = $row->username . ' - ' . $row->empPost->post_name;
    }


    return view('admin.notification.create', ['userGroups' => $userGroups]);
  }



  /**
   * AJAX call
   * POST method
   * Save Notification
   */
  public function createNotification(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'user_list' => "required",
        'notification' => "required",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    // print_r($request->all());

    $userList = $request->input('user_list');
    // $notification = $request->input('notification');

    $type = Notifications::NOTI_SINGLE;

    if ($userList[0] === 'all') {
      $type = Notifications::NOTI_ALL;
    }

    $notiObj = new Notifications();

    $notiObj->message = htmlspecialchars($request->input('notification'));
    $notiObj->type = $type;
    $notiObj->date = date('Y-m-d H:i:s');

    if ($notiObj->save()) {

      // $insertId = $notiObj->id;

      $data = [];
      $date = date('Y-m-d H:i:s');


      if ($type === Notifications::NOTI_SINGLE) {
        foreach ($userList as $user) {

          //if user selected by post
          if (strpos($user, "post") === 0) {

            $postId = str_replace("post#", '', $user);

            //getting all users id whos are associated with this post
            $userIds = Users::select('user_id')
              ->distinct()
              ->where('post', $postId)
              ->where('status', 1)
              ->get();



            foreach ($userIds as $row) {
              $data[] = [
                'notification_id' => $notiObj->id,
                'user_id' => $row->user_id,
                'date' => $date
              ];
            }
          }

          //if user selected by team
          else if (strpos($user, "team") === 0) {

            $teamId = str_replace("team#", '', $user);

            //getting all users id whos are associated with this team
            $userIds = WorkTeamMembers::select('user_id')
              ->distinct()
              ->where('work_team_id', $teamId)
              ->get();

            foreach ($userIds as $row) {
              $data[] = [
                'notification_id' => $notiObj->id,
                'user_id' => $row->user_id,
                'date' => $date
              ];
            }
          } else {

            $data[] = [
              'notification_id' => $notiObj->id,
              'user_id' => (int) $user,
              'date' => $date
            ];
          }
        }
      } else if ($type === Notifications::NOTI_ALL) {
        $data = [
          'notification_id' => $notiObj->id,
          'user_id' => 0,
          'date' => $date
        ];
      }

      //remove duplicate user_ids,if any
      $data = array_map("unserialize", array_unique(array_map("serialize", $data)));


      if (NotificationsUsers::insert($data)) {
        $return['code'] = 200;
        $return['msg'] = 'New notification has been added.';
      } else {
        $return['code'] = 101;
        $return['msg'] = 'Error-DBIx1: Please contact administrator.';
      }
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error-DBIx1: Please contact administrator.';
    }


    return response()->json($return);
  }




  /**
   * View for create notification
   */
  public function viewList()
  {
    return view('admin.notification.list');
  }






  /**
   * AJAX call
   * GET method
   * Notification List
   */
  public function notificationList()
  {
    $noti = Notifications::orderBy('date', 'DESC')
      ->get();

    $return['code'] = 200;
    $return['data'] = $noti;

    return response()->json($return);
  }



  /**
   * AJAX call
   * GET method
   * 
   */
  // public function userList()
  // {
  //   $users = Users::where('user_id', '!=', 1)
  //     ->where('status', 1)
  //     ->select('user_id as id', 'username as value')
  //     ->orderBy('username', 'ASC')
  //     ->get();

  //   $return['code'] = 200;
  //   $return['data'] = $users;

  //   return response()->json($return);
  // }


  public function usersDetails(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'id' => "required|numeric|max:999999999"
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors()->get('id');

      return response()->json($return);
    }


    $result = NotificationsUsers::with(['users', 'users.department', 'users.post', 'users.designation'])
      ->select('id', 'user_id')
      ->where('notification_id', $request->input('id'))
      ->get();


    $return['code'] = 200;
    $return['msg'] = 'Data Found.';
    $return['data'] = $result;

    return response()->json($return);
  }



  /**
   * Update Notification
   */
  public function updateNotification(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'update_id' => "required",
        'update_message' => "required",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    $id = $request->input('update_id');


    $notification = Notifications::find($id);


    if (empty($notification)) {

      $return['code'] = 101;
      $return['msg'] = 'Notification not found!';

      return response()->json($return);
    }


    $notification->message = htmlspecialchars($request->input('update_message'));


    if ($notification->isDirty()) {

      if ($notification->save()) {
        $return['code'] = 200;
        $return['msg'] = ' Notification has been Updated.';
      } else {
        $return['code'] = 101;
        $return['msg'] = 'Error: Please contact administrator.';
      }
    } else {
      $return['code'] = 101;
      $return['msg'] = 'No Changes are found.';
    }

    return response()->json($return);
  }




  /**
   * Delete Notification
   */
  public function deleteNotification(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'id' => "required|numeric"
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 101;
      $return['msg'] = $validator->errors()->get('id');

      return response()->json($return);
    }


    $id = $request->input('id');

    $delNoti = Notifications::find($id);

    if ($delNoti->delete()) {

      NotificationsUsers::where('notification_id', $id)->delete();

      $return['code'] = 200;
      $return['msg'] = 'Notification has been Deleted.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }
}
