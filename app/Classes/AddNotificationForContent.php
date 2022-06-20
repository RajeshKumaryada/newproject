<?php

namespace App\Classes;

use App\Models\Notifications;
use App\Models\NotificationsUsers;
use App\Models\Users;
use App\Models\WorkTeamMembers;

class AddNotificationForContent
{

  /**
   * Send notification to Content writer Team leaders
   * When new request has been made
   */
  public function toLeaders($requestBy)
  {

    //getting all team leaders
    $teamLeaders = WorkTeamMembers::select('work_team_members.user_id', 'work_team_members.member_type')
      ->join('work_team_info', 'work_team_members.work_team_id', '=', 'work_team_info.wt_id')
      ->where('work_team_members.member_type', 'team_leader')
      ->where('work_team_info.team_type', 3)
      ->get();




    $userList = null;

    foreach ($teamLeaders as $row) {
      $userList[] = $row->user_id;
    }


    if (empty($userList)) {
      return null;
    }


    $userMsg = '';
    if (!empty($requestBy)) {
      //getting username and email of user
      $userInfo = Users::select('username', 'email')->where('user_id', $requestBy)->first();

      $userMsg = " from '{$userInfo->username} - {$userInfo->email}'";
    }


    $date = date('Y-m-d H:i:s');
    $notiObj = new Notifications();

    $notiObj->message = htmlspecialchars("Request for new content is arrived{$userMsg}. Please <a href='" . url('') . "/content-writer/request/content/list'>VISIT ON LINK</a> to manage content requests.");
    $notiObj->type = Notifications::NOTI_SINGLE;
    $notiObj->date = $date;



    if ($notiObj->save()) {

      $data = [];


      foreach ($userList as $user) {

        $data[] = [
          'notification_id' => $notiObj->id,
          'user_id' => (int) $user,
          'date' => $date
        ];
      }

      if (NotificationsUsers::insert($data)) {
        return true;
      } else {
        return false;
      }
    }

    return null;
  }


  /**
   * Send notification to Content writer Member
   * When new content has been made assigned
   */
  public function toWriter($assignTo)
  {
    $userMsg = '';
    if (!empty($assignTo)) {
      //getting username and email of user
      $userInfo = Users::select('username', 'email')->where('user_id', $assignTo)->first();

      $userMsg = "Hello, '{$userInfo->username} - {$userInfo->email}', ";
    }


    $date = date('Y-m-d H:i:s');
    $notiObj = new Notifications();

    $notiObj->message = htmlspecialchars("{$userMsg}You are assigned for content. Please <a href='" . url('') . "/content-writer/content/assigned/list'>VISIT ON LINK</a> to view assigned contents.");
    $notiObj->type = Notifications::NOTI_SINGLE;
    $notiObj->date = $date;



    if ($notiObj->save()) {


      $data = [
        'notification_id' => $notiObj->id,
        'user_id' => (int) $assignTo,
        'date' => $date
      ];


      if (NotificationsUsers::insert($data)) {
        return true;
      } else {
        return false;
      }
    }

    return null;
  }



  /**
   * Send notification to Content writer Member
   * Send notification to Content writer Team leaders
   * When seo sent Change Request on content
   */
  public function forChangeRequest($requestBy, $assignTo)
  {
    //getting all team leaders
    $teamLeaders = WorkTeamMembers::select('work_team_members.user_id', 'work_team_members.member_type')
      ->join('work_team_info', 'work_team_members.work_team_id', '=', 'work_team_info.wt_id')
      ->where('work_team_members.member_type', 'team_leader')
      ->where('work_team_info.team_type', 3)
      ->get();

    $userList = null;

    foreach ($teamLeaders as $row) {
      $userList[] = $row->user_id;
    }


    if (empty($userList)) {
      return null;
    }


    $userMsg = '';
    if (!empty($requestBy)) {
      //getting username and email of user
      $userInfo = Users::select('username', 'email')->where('user_id', $requestBy)->first();

      $userMsg = " from '{$userInfo->username} - {$userInfo->email}'";
    }


    $date = date('Y-m-d H:i:s');
    $notiObj = new Notifications();

    $notiObj->message = htmlspecialchars("Request for <b>content changes</b> is arrived{$userMsg}. Please <a href='" . url('') . "/content-writer/request/content/list'>VISIT ON LINK</a> to view remarks.");
    $notiObj->type = Notifications::NOTI_SINGLE;
    $notiObj->date = $date;



    if ($notiObj->save()) {

      $data = [];


      foreach ($userList as $user) {

        $data[] = [
          'notification_id' => $notiObj->id,
          'user_id' => (int) $user,
          'date' => $date
        ];
      }

      NotificationsUsers::insert($data);
    }



    //assign notification to content writer
    $userMsg = '';
    if (!empty($assignTo)) {
      //getting username and email of user
      $userInfo = Users::select('username', 'email')->where('user_id', $assignTo)->first();

      $userMsg = "Hello, '{$userInfo->username} - {$userInfo->email}', ";
    }


    $date = date('Y-m-d H:i:s');
    $notiObj = new Notifications();

    $notiObj->message = htmlspecialchars("{$userMsg}You are assigned for <b>content change</b>. Please <a href='" . url('') . "/content-writer/content/assigned/list'>VISIT ON LINK</a> to <b>view and read remarks</b> on assigned contents.");
    $notiObj->type = Notifications::NOTI_SINGLE;
    $notiObj->date = $date;



    if ($notiObj->save()) {


      $data = [
        'notification_id' => $notiObj->id,
        'user_id' => (int) $assignTo,
        'date' => $date
      ];


      if (NotificationsUsers::insert($data)) {
        return true;
      } else {
        return false;
      }
    }
  }
}
