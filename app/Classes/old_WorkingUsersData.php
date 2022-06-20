<?php

namespace App\Classes;

use App\Models\LoginLocation;
use App\Models\UsersAlam;

class WorkingUsersData
{


  /**
   * This function for Admin
   * Calculate Working hours for today working user
   */
  public function calculateForAdmin($taskList, $users)
  {
    $dateDiffObj = new DateDiffCalculator();

    $tempData = [];

    $totHours = 0;
    $totMinutes = 0;
    $totSeconds = 0;

    //vars for last active task
    $start_time = '';
    $task = '';

    //store is any task running
    $isTaskActive = false;
    $star_firstt_t = '';
    $end_last_t = '';
    $end_time_last = '';

    foreach ($taskList as $row) {

      if (!empty($row->end_time)) {
 
        $dateDiffObj->calculate($row->start_time, $row->end_time);
        $totHours += $dateDiffObj->getHr();
        $totMinutes += $dateDiffObj->getMin();
        $totSeconds += $dateDiffObj->getSec();
      } else {

        $dateDiffObj->calculate($row->start_time, date('Y-m-d H:i:s'));
        $totHours += $dateDiffObj->getHr();
        $totMinutes += $dateDiffObj->getMin();
        $totSeconds += $dateDiffObj->getSec();

          $isTaskActive = true;
        $start_time = $row->start_time;
       
        $task = $row->task;

        //check for seo
        if ($users->post === 4) {

          $task = $row->seoTaskList()->first()->task;
        }
      }

      $start_first_time = '';

      $start_first_time = $row->whereDate('start_time', date('Y-m-d'))->first()->start_time;

      if (!empty($start_first_time)) {
        $star_firstt_t = date("H:i:s", strtotime($start_first_time));
      } else {
        $star_firstt_t = '';
      }


      //  $end_last_t = [];
      //  $end_time_last = $row->whereDate('end_time',date('Y-m-d'))->orderBy('id','DESC')->whereOr('status','1')->first()->end_time;

    
       $end_time_last = $row->whereDate('end_time', date('Y-m-d'))->orderBy('id','DESC')->first()->end_time;
        
       if(!empty($end_time_last)){
          $end_last_t = date("h:i:s", strtotime($end_time_last));
        }else{
          $end_last_t = [];
        }


      //calculate total working hours
      DateDiffCalculator::calHrMinSec($totHours, $totMinutes, $totSeconds);
    }


    $gender = !empty($users->usersInfo->gender) ? $users->usersInfo->gender : '';


    $status_alarm = '';

    $alarm = UsersAlam::where('user_id', $users->user_id)->first();

    if (!empty($alarm)) {
      $status_alarm = $alarm->status;
    } else {
      $status_alarm = '';
    }

    $login_location = '';

    $loginLoc = LoginLocation::where('user_id', $users->user_id)->whereDate('date', date('Y-m-d'))->first();
    if (!empty($loginLoc)) {
      $login_location = $loginLoc->location;
    } else {
      $login_location = '';
    }


    $tempData = [
      'user_id' => $users->user_id,
      'username' => $users->username,
      'gender' => $gender,
      'designation' => $users->designation()->first()->des_name,
      'task' => $task,
      'is_task_active' => $isTaskActive,
      'start_time' =>  $start_time,
      'start_time_first' => $star_firstt_t,
      'end_time' => $end_last_t,
      'total_working_hours' => DateDiffCalculator::getToTimeFormat($totHours, $totMinutes, $totSeconds),
      'total_working_hours_arr' => [$totHours, $totMinutes, $totSeconds],
      'alarm_status' => $status_alarm,
      'login_loc' => $login_location
    ];

    return $tempData;
  }



  /**
   * This function for Users, we hide some task info
   * Calculate Working hours for today working user
   */
  public function calculateForUser($taskList, $users)
  {
    $dateDiffObj = new DateDiffCalculator();

    // $tempData = [];

    $totHours = 0;
    $totMinutes = 0;
    $totSeconds = 0;

    //vars for last active task
    $start_time = '';
    $task = '********';

    //store is any task running
    $isTaskActive = false;

    foreach ($taskList as $row) {

      if (!empty($row->end_time)) {
        $dateDiffObj->calculate($row->start_time, $row->end_time);
        $totHours += $dateDiffObj->getHr();
        $totMinutes += $dateDiffObj->getMin();
        $totSeconds += $dateDiffObj->getSec();
      } else {

        $dateDiffObj->calculate($row->start_time, date('Y-m-d H:i:s'));
        $totHours += $dateDiffObj->getHr();
        $totMinutes += $dateDiffObj->getMin();
        $totSeconds += $dateDiffObj->getSec();

        $isTaskActive = true;
        $start_time = $row->start_time;
        // $task = $row->task;

        //check for seo
        if ($users->post === 4) {
          $task = $row->seoTaskList()->first()->task;
        }

        //check for content writer
        else if ($users->post === 1) {
          $task = $row->task;
        }
      }

      //calculate total working hours
      DateDiffCalculator::calHrMinSec($totHours, $totMinutes, $totSeconds);
    }

    $tempData = [
      'username' => $users->username,
      'designation' => $users->designation()->first()->des_name,
      'task' => $task,
      'is_task_active' => $isTaskActive,
      'start_time' => $start_time,
      'total_working_hours' => DateDiffCalculator::getToTimeFormat($totHours, $totMinutes, $totSeconds),
      'total_working_hours_arr' => [$totHours, $totMinutes, $totSeconds]
    ];

    return $tempData;
  }
}
