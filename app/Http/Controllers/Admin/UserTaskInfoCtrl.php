<?php

namespace App\Http\Controllers\Admin;

use App\Classes\DateDiffCalculator;
use App\Classes\WorkReportStatus;
use App\Http\Controllers\Controller;
// use App\Models\ContentWriterTask;
// use App\Models\DesignerTask;
// use App\Models\DeveloperTask;
// use App\Models\HumanResourceTask;
// use App\Models\SeoExecutiveTask;
// use App\Models\SeoTaskList;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserTaskInfoCtrl extends Controller
{

  /**
   * View for the user task
   */
  public function usersTask($post)
  {

    switch ($post) {

      case "developer":
        return view('admin.task_info.developer_task_info');
        break;


      case "content-writer":
        return view('admin.task_info.content_writer_task_info');
        break;


      case "designer":
        return view('admin.task_info.designer_task_info');
        break;


      case "seo":
        return view('admin.task_info.seo_task_info');
        break;


      case "human-resource":
        return view('admin.task_info.hr_task_info');
        break;


      case "back-office":
        return view('admin.task_info.back_office_task_info');
        break;
    }
  }



  /**
   * Get User List by Post (Position)
   */
  public function usersByPost($post)
  {

    switch ($post) {

      case "developer":
        $users = Users::select('user_id AS id', 'username AS value', 'status')
          ->where('post', 3)
          ->orderBy('status', 'DESC')
          ->orderBy('username', 'ASC')
          ->get();
        break;


      case "content-writer":
        $users = Users::select('user_id AS id', 'username AS value', 'status')
          ->where('post', 1)
          ->orderBy('status', 'DESC')
          ->orderBy('username', 'ASC')
          ->get();
        break;


      case "designer":
        $users = Users::select('user_id AS id', 'username AS value', 'status')
          ->where('post', 2)
          ->orderBy('status', 'DESC')
          ->orderBy('username', 'ASC')
          ->get();
        break;


      case "seo":
        $users = Users::select('user_id AS id', 'username AS value', 'status')
          ->where('post', 4)
          ->orderBy('status', 'DESC')
          ->orderBy('username', 'ASC')
          ->get();
        break;


      case "human-resource":
        $users = Users::select('user_id AS id', 'username AS value', 'status')
          ->where('post', 5)
          ->orderBy('status', 'DESC')
          ->orderBy('username', 'ASC')
          ->get();
        break;


      case "back-office":
        $users = Users::select('user_id AS id', 'username AS value', 'status')
          ->where('post', 8)
          ->orderBy('status', 'DESC')
          ->orderBy('username', 'ASC')
          ->get();
        break;
    }



    if (empty($users)) {
      $return['code'] = 404;
      $return['msg'] = "No data found!";
      $return['data'] = null;

      return response()->json($return);
    }


    //fileter user by status
    $filteredUsers = [];

    foreach ($users as $row) {
      if ($row->status === 1) {
        $row->value = $row->value . " - Active";
      } else {
        $row->value = $row->value . " - Inactive";
      }

      $filteredUsers[] = $row;
    }


    $return['code'] = 200;
    $return['data'] = $filteredUsers;

    return response()->json($return);
  }




  /**
   * ::::::::::::::::::::::::::::::::::::::
   * Getting Task List for all users
   * :::::::::::::::::::::::::::::::::::::
   */
  public function getTaskList(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'usertype' => "required",
        'username' => "required|numeric|max:99999999",
        'date' => "required|date"
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    $userType = $request->input('usertype');

    $userId = $request->input('username');
    $date = $request->input('date');


    switch ($userType) {

      case "developer":
        // $taskList = DeveloperTask::select('developer_task.*', 'trace_location.latitude', 'trace_location.longitude')
        //   ->leftJoin('trace_location', function ($join) {
        //     $join->on('developer_task.id', 'trace_location.task_id')
        //       ->on('developer_task.user_id', 'trace_location.user_id');
        //   })
        //   ->where('developer_task.user_id', $request->input('username'))
        //   ->whereDate('developer_task.start_time', $request->input('date'))
        //   ->orderBy('developer_task.id', 'DESC')
        //   ->get();


        $taskList = DB::select("SELECT *, 
        (SELECT CONCAT(`trace_location`.`latitude`,',', `trace_location`.`longitude`) as `loc` FROM `trace_location` WHERE `trace_location`.`task_id` = `developer_task`.`id` AND `trace_location`.`user_id` = $userId AND date(`trace_location`.`date`) = '$date' AND `trace_location`.`work_type` = 'start' LIMIT 1) as `start`,
        (SELECT CONCAT(`trace_location`.`latitude`,',', `trace_location`.`longitude`) as `loc` FROM `trace_location` WHERE `trace_location`.`task_id` = `developer_task`.`id` AND `trace_location`.`user_id` = $userId AND date(`trace_location`.`date`) = '$date' AND `trace_location`.`work_type` = 'finish' LIMIT 1) as `finish`
         FROM `developer_task` WHERE date(`start_time`) = '$date' AND `user_id` = '$userId' ORDER BY `id` DESC;");
        break;



      case "designer":
        // $taskList = DesignerTask::where('user_id', $request->input('username'))
        //   ->whereDate('start_time', $request->input('date'))
        //   ->orderBy('id', 'DESC')
        //   ->get();

        $taskList = DB::select("SELECT *, 
        (SELECT CONCAT(`trace_location`.`latitude`,',', `trace_location`.`longitude`) as `loc` FROM `trace_location` WHERE `trace_location`.`task_id` = `designer_task`.`id` AND `trace_location`.`user_id` = $userId AND date(`trace_location`.`date`) = '$date' AND `trace_location`.`work_type` = 'start' LIMIT 1) as `start`,
        (SELECT CONCAT(`trace_location`.`latitude`,',', `trace_location`.`longitude`) as `loc` FROM `trace_location` WHERE `trace_location`.`task_id` = `designer_task`.`id` AND `trace_location`.`user_id` = $userId AND date(`trace_location`.`date`) = '$date' AND `trace_location`.`work_type` = 'finish' LIMIT 1) as `finish`
         FROM `designer_task` WHERE date(`start_time`) = '$date' AND `user_id` = '$userId' ORDER BY `id` DESC;");
        break;



      case "seo":
        // $taskList = SeoExecutiveTask::where('user_id', $request->input('username'))
        //   ->whereDate('start_time', $request->input('date'))
        //   ->orderBy('id', 'DESC')
        //   ->get();

        $taskList = DB::select("SELECT `seo_task`.*, 
        (SELECT CONCAT(`trace_location`.`latitude`,',', `trace_location`.`longitude`) as `loc` FROM `trace_location` WHERE `trace_location`.`task_id` = `seo_task`.`id` AND `trace_location`.`user_id` = $userId AND date(`trace_location`.`date`) = '$date' AND `trace_location`.`work_type` = 'start' LIMIT 1) as `start`,
        (SELECT CONCAT(`trace_location`.`latitude`,',', `trace_location`.`longitude`) as `loc` FROM `trace_location` WHERE `trace_location`.`task_id` = `seo_task`.`id` AND `trace_location`.`user_id` = $userId AND date(`trace_location`.`date`) = '$date' AND `trace_location`.`work_type` = 'finish' LIMIT 1) as `finish`,
        `seo_task_list`.`task` as `task_name`
         FROM `seo_task` LEFT JOIN `seo_task_list` ON `seo_task`.`task` = `seo_task_list`.`id`  WHERE date(`seo_task`.`start_time`) = '$date' AND `seo_task`.`user_id` = '$userId' ORDER BY `seo_task`.`id` DESC;");
        break;


      case "human-resource":
        // $taskList = HumanResourceTask::where('user_id', $request->input('username'))
        //   ->whereDate('start_time', $request->input('date'))
        //   ->orderBy('id', 'DESC')
        //   ->get();

        $taskList = DB::select("SELECT *, 
        (SELECT CONCAT(`trace_location`.`latitude`,',', `trace_location`.`longitude`) as `loc` FROM `trace_location` WHERE `trace_location`.`task_id` = `hr_task`.`id` AND `trace_location`.`user_id` = $userId AND date(`trace_location`.`date`) = '$date' AND `trace_location`.`work_type` = 'start' LIMIT 1) as `start`,
        (SELECT CONCAT(`trace_location`.`latitude`,',', `trace_location`.`longitude`) as `loc` FROM `trace_location` WHERE `trace_location`.`task_id` = `hr_task`.`id` AND `trace_location`.`user_id` = $userId AND date(`trace_location`.`date`) = '$date' AND `trace_location`.`work_type` = 'finish' LIMIT 1) as `finish`
         FROM `hr_task` WHERE date(`start_time`) = '$date' AND `user_id` = '$userId' ORDER BY `id` DESC;");
        break;



      case "back-office":

        $taskList = DB::select("SELECT *, 
          (SELECT CONCAT(`trace_location`.`latitude`,',', `trace_location`.`longitude`) as `loc` FROM `trace_location` WHERE `trace_location`.`task_id` = `back_office_task`.`id` AND `trace_location`.`user_id` = $userId AND date(`trace_location`.`date`) = '$date' AND `trace_location`.`work_type` = 'start' LIMIT 1) as `start`,
          (SELECT CONCAT(`trace_location`.`latitude`,',', `trace_location`.`longitude`) as `loc` FROM `trace_location` WHERE `trace_location`.`task_id` = `back_office_task`.`id` AND `trace_location`.`user_id` = $userId AND date(`trace_location`.`date`) = '$date' AND `trace_location`.`work_type` = 'finish' LIMIT 1) as `finish`
           FROM `back_office_task` WHERE date(`start_time`) = '$date' AND `user_id` = '$userId' ORDER BY `id` DESC;");
        break;
    }




    //check if running task available


    if (empty($taskList)) {

      $return['code'] = 300;
      $return['msg'] = 'No Data';

      return response()->json($return);
    }


    $retData = [];

    $totHours = 0;
    $totMinutes = 0;
    $totSeconds = 0;

    //store is any task running
    // $isTaskActive = false;

    $dateDiffObj = new DateDiffCalculator();

    foreach ($taskList as $row) {

      $end_time = "Active";
      $total_time = "Active";
      $action = "Active";
      $status = WorkReportStatus::getStaus($row->status);


      if (!empty($row->end_time)) {

        $end_time = date("h:i:s A", strtotime($row->end_time));



        $dateDiffObj->calculate($row->start_time, $row->end_time);
        $totHours += $dateDiffObj->getHr();
        $totMinutes += $dateDiffObj->getMin();
        $totSeconds += $dateDiffObj->getSec();
        $total_time = $dateDiffObj->getTotalTime("%Hh %Im %Ss");

        $action = "Finished";
      }


      //calculate total working hours
      DateDiffCalculator::calHrMinSec($totHours, $totMinutes, $totSeconds);


      $task = $row->task;

      if (!empty($row->seoTaskList->task)) {
        $task = $row->seoTaskList->task;
      }


      $retData[] = [
        'task_id' => Crypt::encryptString($row->id),
        'date' => date("Y-m-d", strtotime($row->start_time)),
        'start_time' => date("h:i:s A", strtotime($row->start_time)),
        'end_time' => $end_time,
        'task' => $task,
        'remark' => $row->remark,
        'status' => $status,
        'total_time' => $total_time,
        'action' => $action,
        'start' => $row->start,
        'finish' => $row->finish,
        'task_name' => (!empty($row->task_name)) ? $row->task_name : '',
        // 'row' => $row
      ];
    }



    $return['total_working_hours'] = DateDiffCalculator::getToTimeFormat($totHours, $totMinutes, $totSeconds);
    $return['total_working_hours_arr'] = [$totHours, $totMinutes, $totSeconds];
    // $return['is_task_active'] = $isTaskActive;


    $return['code'] = 200;
    $return['msg'] = 'Data found.';
    $return['data'] = $retData;
    $return['token'] = csrf_token();


    return response()->json($return);
  }




  /**
   * :::::::::::::::::::::::::::::::::::::
   * Content Writer Task List
   * :::::::::::::::::::::::::::::::::::::
   */
  public function cwTaskList(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'usertype' => "required",
        'username' => "required|numeric|max:99999999",
        'date' => "required|date"
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    $userType = $request->input('usertype');
    $date = $request->input('date');
    $userId = $request->input('username');

    if ($userType === 'content-writer') {
      // $taskList = ContentWriterTask::where('user_id', $request->input('username'))
      //   ->whereDate('start_time', $request->input('date'))
      //   ->orderBy('id', 'DESC')
      //   ->get();

      $taskList = DB::select("SELECT *, 
        (SELECT CONCAT(`trace_location`.`latitude`,',', `trace_location`.`longitude`) as `loc` FROM `trace_location` WHERE `trace_location`.`task_id` = `writer_task`.`id` AND `trace_location`.`user_id` = $userId AND date(`trace_location`.`date`) = '$date' AND `trace_location`.`work_type` = 'start' LIMIT 1) as `start`,
        (SELECT CONCAT(`trace_location`.`latitude`,',', `trace_location`.`longitude`) as `loc` FROM `trace_location` WHERE `trace_location`.`task_id` = `writer_task`.`id` AND `trace_location`.`user_id` = $userId AND date(`trace_location`.`date`) = '$date' AND `trace_location`.`work_type` = 'finish' LIMIT 1) as `finish`
         FROM `writer_task` WHERE date(`start_time`) = '$date' AND `user_id` = '$userId' ORDER BY `id` DESC;");
    }


    //check if running task available


    if (empty($taskList)) {

      $return['code'] = 300;
      $return['msg'] = 'No Data';

      return response()->json($return);
    }


    $retData = [];

    $totHours = 0;
    $totMinutes = 0;
    $totSeconds = 0;

    //store is any task running
    // $isTaskActive = false;

    $dateDiffObj = new DateDiffCalculator();

    foreach ($taskList as $row) {
      $end_time = "Active";
      $total_time = "Active";
      $action = "Active";
      $status = WorkReportStatus::getStaus($row->status);


      if (!empty($row->end_time)) {

        $end_time = date("h:i:s A", strtotime($row->end_time));

        $dateDiffObj->calculate($row->start_time, $row->end_time);

        $totHours += $dateDiffObj->getHr();
        $totMinutes += $dateDiffObj->getMin();
        $totSeconds += $dateDiffObj->getSec();
        $total_time = $dateDiffObj->getTotalTime("%Hh %Im %Ss");

        $action = "Finished";
      }


      //calculate total working hours
      DateDiffCalculator::calHrMinSec($totHours, $totMinutes, $totSeconds);


      $retData[] = [
        'task_id' => Crypt::encryptString($row->id),
        'date' => date("Y-m-d", strtotime($row->start_time)),
        'start_time' => date("h:i:s A", strtotime($row->start_time)),
        'end_time' => $end_time,
        'task' => $row->task,
        'word_count' => $row->word_count,
        'file_url' => $row->file_link,
        'status' => $status,
        'total_time' => $total_time,
        'action' => $action,
        'start' => $row->start,
        'finish' => $row->finish,
      ];
    }

    $return['total_working_hours'] = DateDiffCalculator::getToTimeFormat($totHours, $totMinutes, $totSeconds);
    $return['total_working_hours_arr'] = [$totHours, $totMinutes, $totSeconds];
    // $return['is_task_active'] = $isTaskActive;

    $return['code'] = 200;
    $return['msg'] = 'Data found.';
    $return['data'] = $retData;
    $return['token'] = csrf_token();

    return response()->json($return);
  }
}
