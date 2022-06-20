<?php

namespace App\Http\Controllers\Admin\Attendance;

use App\Classes\WorkingUsersData;
use App\Http\Controllers\Controller;
use App\Models\BackOfficeTask;
use App\Models\ContentWriterTask;
use App\Models\DesignerTask;
use App\Models\DeveloperTask;
use App\Models\HumanResourceTask;
use App\Models\SeoExecutiveTask;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceByDateCtrl extends Controller
{


  public function getDateEmployeeForm()
  {
    return view('admin.attendance.attendance_by_date');
  }




  public function getDateEmployeeActive(Request $request)
  {

    $crrDate = date('Y-m-d');

    $validator = Validator::make(
      $request->all(),
      [
        'filter_date' => "required|date|before_or_equal:{$crrDate}",
      ]
    );

    if ($validator->fails()) {
      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }



    $date = $request->input('filter_date');

    //select all users
    $users = Users::select('user_id', 'username', 'designation', 'post')
      ->where('status', 1)
      ->orderBy('post', 'ASC')
      ->orderBy('username', 'ASC')
      ->get();



    $returnData = [];
    $workingUsersData = new WorkingUsersData();

    foreach ($users as $row1) {


      //Content Writer
      if ($row1->post === 1) {
        $taskList = ContentWriterTask::select('start_time', 'end_time', 'task')
          ->where('user_id', $row1->user_id)
          ->whereDate('start_time', $date)
          ->whereNotNull('end_time')
          ->orderBy('id', 'DESC')
          ->get();


        //if data not found
        if ($taskList->isEmpty()) {
          // echo 'continue';
          $returnData[] = [
            'is_worked' => 'no',
            'designation' => $row1->designation()->first()->des_name,
            'total_working_hours' => "<span class='text-danger'>0h 0m 0s",
            'user_id' => $row1->user_id,
            'username' => $row1->username

          ];
          continue;
        }

        $returnData[] = array_merge($workingUsersData->calculateForAdmin($taskList, $row1), ['is_worked' => 'yes']);

        //end Content Writer
      }


      //Designer
      else if ($row1->post === 2) {
        $taskList = DesignerTask::select('start_time', 'end_time', 'task')
          ->where('user_id', $row1->user_id)
          ->whereDate('start_time', $date)
          ->whereNotNull('end_time')
          ->orderBy('id', 'DESC')
          ->get();


        //if data not found
        if ($taskList->isEmpty()) {

          $returnData[] = [
            'is_worked' => 'no',
            'designation' => $row1->designation()->first()->des_name,
            'total_working_hours' => "<span class='text-danger'>0h 0m 0s",
            'user_id' => $row1->user_id,
            'username' => $row1->username

          ];
          // echo 'continue';
          continue;
        }

        $returnData[] = array_merge($workingUsersData->calculateForAdmin($taskList, $row1), ['is_worked' => 'yes']);

        //end Designer
      }


      //Developer
      else if ($row1->post === 3) {
        $taskList = DeveloperTask::select('start_time', 'end_time', 'task')
          ->where('user_id', $row1->user_id)
          ->whereDate('start_time', $date)
          ->whereNotNull('end_time')
          ->orderBy('id', 'DESC')
          ->get();


        //if data not found
        if ($taskList->isEmpty()) {
          $returnData[] = [
            'is_worked' => 'no',
            'designation' => $row1->designation()->first()->des_name,
            'total_working_hours' => "<span class='text-danger'>0h 0m 0s",
            'user_id' => $row1->user_id,
            'username' => $row1->username

          ];
          // echo 'continue';
          continue;
        }

        $returnData[] = array_merge($workingUsersData->calculateForAdmin($taskList, $row1), ['is_worked' => 'yes']);

        //end Developer
      }



      //Seo
      else if ($row1->post === 4) {
        $taskList = SeoExecutiveTask::select('start_time', 'end_time', 'task')
          ->where('user_id', $row1->user_id)
          ->whereDate('start_time', $date)
          ->whereNotNull('end_time')
          ->orderBy('id', 'DESC')
          ->get();


        //if data not found
        if ($taskList->isEmpty()) {
          $returnData[] = [
            'is_worked' => 'no',
            'designation' => $row1->designation()->first()->des_name,
            'total_working_hours' => "<span class='text-danger'>0h 0m 0s",
            'user_id' => $row1->user_id,
            'username' => $row1->username

          ];
          // echo 'continue';
          continue;
        }

        $returnData[] = array_merge($workingUsersData->calculateForAdmin($taskList, $row1), ['is_worked' => 'yes']);

        //end Seo
      }



      //Hr
      else if ($row1->post === 5) {
        $taskList = HumanResourceTask::select('start_time', 'end_time', 'task')
          ->where('user_id', $row1->user_id)
          ->whereDate('start_time', $date)
          ->whereNotNull('end_time')
          ->orderBy('id', 'DESC')
          ->get();


        //if data not found
        if ($taskList->isEmpty()) {
          $returnData[] = [
            'is_worked' => 'no',
            'designation' => $row1->designation()->first()->des_name,
            'total_working_hours' => "<span class='text-danger'>0h 0m 0s",
            'user_id' => $row1->user_id,
            'username' => $row1->username

          ];
          // echo 'continue';
          continue;
        }

        $returnData[] = array_merge($workingUsersData->calculateForAdmin($taskList, $row1), ['is_worked' => 'yes']);

        //end Hr
      }


      //Back Office
      else if ($row1->post === 8) {
        $taskList = BackOfficeTask::select('start_time', 'end_time', 'task')
          ->where('user_id', $row1->user_id)
          ->whereDate('start_time', $date)
          ->whereNotNull('end_time')
          ->orderBy('id', 'DESC')
          ->get();


        //if data not found
        if ($taskList->isEmpty()) {
          $returnData[] = [
            'is_worked' => 'no',
            'designation' => $row1->designation()->first()->des_name,
            'total_working_hours' => "<span class='text-danger'>0h 0m 0s",
            'user_id' => $row1->user_id,
            'username' => $row1->username

          ];
          // echo 'continue';
          continue;
        }

        $returnData[] = array_merge($workingUsersData->calculateForAdmin($taskList, $row1), ['is_worked' => 'yes']);

        //end Hr
      }



      //end $users loop
    }



    if (!empty($returnData)) {
      $return['code'] = 200;
      $return['msg'] = 'Data Found';
      $return['data'] = $returnData;
    } else {
      $return['code'] = 101;
      $return['msg'] = 'No Data Found';
    }

    return response()->json($return);
  }
}
