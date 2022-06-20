<?php

namespace App\Http\Controllers\WorkingUsers;

use App\Classes\WorkingUsersData;
use App\Http\Controllers\Controller;
use App\Models\BackOfficeTask;
use App\Models\ContentWriterTask;
use App\Models\DesignerTask;
use App\Models\DeveloperTask;
use App\Models\HumanResourceTask;
use App\Models\SeoExecutiveTask;
use App\Models\Users;

class WorkingUsersCtrl extends Controller
{


  /**
   * View for today active and working users
   */
  public function viewActiveUsers()
  {
    return view('working_users.active_users');
  }



  /**
   * AJAX Call
   * GET method
   */
  public function getWorkingUsersTime()
  {
    //:::::::::::::::::::::::::
    // Select Working SEOs
    //:::::::::::::::::::::::::

    //select all users
    $users = Users::select('user_id', 'username', 'designation', 'post')
      ->where('status', 1)
      ->orderBy('post', 'ASC')
      ->orderBy('username', 'ASC')
      ->get();

    if (empty($users)) {
      $users = [];
    }


    $returnData = [];
    $workingUsersData = new WorkingUsersData();


    foreach ($users as $row1) {



      //Content Writer
      if ($row1->post === 1) {
        $taskList = ContentWriterTask::select('start_time', 'end_time', 'task')
          ->where('user_id', $row1->user_id)
          ->whereDate('start_time', date("Y-m-d"))
          ->orderBy('id', 'DESC')
          ->get();


        //if data not found
        if ($taskList->isEmpty()) {
          // echo 'continue';
          continue;
        }

        $returnData[] = $workingUsersData->calculateForUser($taskList, $row1);

        //end Content Writer
      }


      //Designer
      else if ($row1->post === 2) {
        $taskList = DesignerTask::select('start_time', 'end_time')
          ->where('user_id', $row1->user_id)
          ->whereDate('start_time', date("Y-m-d"))
          ->orderBy('id', 'DESC')
          ->get();


        //if data not found
        if ($taskList->isEmpty()) {
          // echo 'continue';
          continue;
        }

        $returnData[] = $workingUsersData->calculateForUser($taskList, $row1);

        //end Designer
      }


      //Developer
      else if ($row1->post === 3) {
        $taskList = DeveloperTask::select('start_time', 'end_time')
          ->where('user_id', $row1->user_id)
          ->whereDate('start_time', date("Y-m-d"))
          ->orderBy('id', 'DESC')
          ->get();


        //if data not found
        if ($taskList->isEmpty()) {
          // echo 'continue';
          continue;
        }

        $returnData[] = $workingUsersData->calculateForUser($taskList, $row1);

        //end Developer
      }



      //Seo
      else if ($row1->post === 4) {
        $taskList = SeoExecutiveTask::select('start_time', 'end_time', 'task')
          ->where('user_id', $row1->user_id)
          ->whereDate('start_time', date("Y-m-d"))
          ->orderBy('id', 'DESC')
          ->get();


        //if data not found
        if ($taskList->isEmpty()) {
          // echo 'continue';
          continue;
        }

        $returnData[] = $workingUsersData->calculateForUser($taskList, $row1);

        //end Seo
      }



      //Hr
      else if ($row1->post === 5) {
        $taskList = HumanResourceTask::select('start_time', 'end_time')
          ->where('user_id', $row1->user_id)
          ->whereDate('start_time', date("Y-m-d"))
          ->orderBy('id', 'DESC')
          ->get();


        //if data not found
        if ($taskList->isEmpty()) {
          // echo 'continue';
          continue;
        }

        $returnData[] = $workingUsersData->calculateForUser($taskList, $row1);

        //end Hr
      }


      //back office
      else if ($row1->post === 8) {
        $taskList = BackOfficeTask::select('start_time', 'end_time')
          ->where('user_id', $row1->user_id)
          ->whereDate('start_time', date("Y-m-d"))
          ->orderBy('id', 'DESC')
          ->get();


        //if data not found
        if ($taskList->isEmpty()) {
          // echo 'continue';
          continue;
        }

        $returnData[] = $workingUsersData->calculateForUser($taskList, $row1);

        //end Hr
      }



      //end $users loop
    }



    $return['code'] = 200;
    $return['msg'] = 'Data found.';
    $return['data'] = $returnData;

    // print_r($return);

    return response()->json($return);
  }
}
