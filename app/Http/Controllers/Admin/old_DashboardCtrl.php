<?php

namespace App\Http\Controllers\Admin;

use App\Classes\WorkingUsersData;
use App\Http\Controllers\Controller;
use App\Models\BackOfficeTask;
use App\Models\ContentWriterTask;
use App\Models\DesignerTask;
use App\Models\DeveloperTask;
use App\Models\HumanResourceTask;
use App\Models\SeoExecutiveTask;
use App\Models\Users;

class DashboardCtrl extends Controller
{

  /**
   * 
   */
  public function index()
  {
    return view('admin.dashboard');
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

        $returnData[] = $workingUsersData->calculateForAdmin($taskList, $row1);

        //end Content Writer
      }


      //Designer
      else if ($row1->post === 2) {
        $taskList = DesignerTask::select('start_time', 'end_time', 'task')
          ->where('user_id', $row1->user_id)
          ->whereDate('start_time', date("Y-m-d"))
          ->orderBy('id', 'DESC')
          ->get();


        //if data not found
        if ($taskList->isEmpty()) {
          // echo 'continue';
          continue;
        }

        $returnData[] = $workingUsersData->calculateForAdmin($taskList, $row1);

        //end Designer
      }


      //Developer
      else if ($row1->post === 3) {
        $taskList = DeveloperTask::select('start_time', 'end_time', 'task')
          ->where('user_id', $row1->user_id)
          ->whereDate('start_time', date("Y-m-d"))
          ->orderBy('id', 'DESC')
          ->get();


        //if data not found
        if ($taskList->isEmpty()) {
          // echo 'continue';
          continue;
        }

        $returnData[] = $workingUsersData->calculateForAdmin($taskList, $row1);

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

        $returnData[] = $workingUsersData->calculateForAdmin($taskList, $row1);

        //end Seo
      }



      //Hr
      else if ($row1->post === 5) {
        $taskList = HumanResourceTask::select('start_time', 'end_time', 'task')
          ->where('user_id', $row1->user_id)
          ->whereDate('start_time', date("Y-m-d"))
          ->orderBy('id', 'DESC')
          ->get();


        //if data not found
        if ($taskList->isEmpty()) {
          // echo 'continue';
          continue;
        }

        $returnData[] = $workingUsersData->calculateForAdmin($taskList, $row1);

        //end Hr
      }


      //Back Office
      else if ($row1->post === 8) {
        $taskList = BackOfficeTask::select('start_time', 'end_time', 'task')
          ->where('user_id', $row1->user_id)
          ->whereDate('start_time', date("Y-m-d"))
          ->orderBy('id', 'DESC')
          ->get();


        //if data not found
        if ($taskList->isEmpty()) {
          // echo 'continue';
          continue;
        }

        $returnData[] = $workingUsersData->calculateForAdmin($taskList, $row1);

        //end Hr
      }



      //end $users loop
    }



    $return['code'] = 200;
    $return['msg'] = 'Data found.';
    $return['data'] = $returnData;
    $return['user_count'] = $users->count();

    // print_r($return);

    return response()->json($return);
  }






  /**
   * AJAX call
   * POST method
   */
  // public function getWorkingUsers()
  // {
  //   //:::::::::::::::::::::::::
  //   // Select Working SEOs
  //   //:::::::::::::::::::::::::

  //   $seoWork = SeoExecutiveTask::with(['seoTaskList', 'users.designation'])
  //     ->where('complete', 0)
  //     ->whereDate('start_time', date("Y-m-d"))
  //     ->orderBy('id', 'DESC')
  //     ->get();

  //   $data['seo_work'] = $seoWork;



  //   //::::::::::::::::::::::::::::::::
  //   // Select Working Content Writers
  //   //::::::::::::::::::::::::::::::::

  //   $cWork = ContentWriterTask::with(['users.designation'])
  //     ->where('complete', 0)
  //     ->whereDate('start_time', date("Y-m-d"))
  //     ->orderBy('id', 'DESC')
  //     ->get();

  //   $data['cw_work'] = $cWork;


  //   //::::::::::::::::::::::::::::::::
  //   // Select Working HR
  //   //::::::::::::::::::::::::::::::::

  //   $hrWork = HumanResourceTask::with(['users.designation'])
  //     ->where('complete', 0)
  //     ->whereDate('start_time', date("Y-m-d"))
  //     ->orderBy('id', 'DESC')
  //     ->get();

  //   $data['hr_work'] = $hrWork;



  //   //::::::::::::::::::::::::::::::::
  //   // Select Working Designer
  //   //::::::::::::::::::::::::::::::::
  //   $desWork = DesignerTask::with(['users.designation'])
  //     ->where('complete', 0)
  //     ->whereDate('start_time', date("Y-m-d"))
  //     ->orderBy('id', 'DESC')
  //     ->get();

  //   $data['des_work'] = $desWork;



  //   //::::::::::::::::::::::::::::::::
  //   // Select Working Developer
  //   //::::::::::::::::::::::::::::::::
  //   $devWork = DeveloperTask::with(['users.designation'])
  //     ->where('complete', 0)
  //     ->whereDate('start_time', date("Y-m-d"))
  //     ->orderBy('id', 'DESC')
  //     ->get();


  //   $data['dev_work'] = $devWork;


  //   $return['code'] = 200;
  //   $return['msg'] = 'Data found.';
  //   $return['data'] = $data;


  //   // print_r($return);

  //   return response()->json($return);
  // }
}
