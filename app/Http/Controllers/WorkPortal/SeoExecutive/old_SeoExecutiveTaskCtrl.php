<?php

namespace App\Http\Controllers\WorkPortal\SeoExecutive;


use App\Classes\DateDiffCalculator;
use App\Classes\TrackSession;
use App\Classes\WorkReportStatus;
use App\Http\Controllers\Controller;
use App\Models\SeoExecutiveTask;
use App\Models\TraceLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class SeoExecutiveTaskCtrl extends Controller
{


  /**
   * :::::::::::::::::::::::::::::::::::::::::::
   * Start New Task
   * :::::::::::::::::::::::::::::::::::::::::::
   */
  public function addTask(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'task_details' => "required|numeric|min:0|max:999999"
      ]
    );

    // @php echo( ($row->checklist_type === "req")?"required":"" ); @endphp

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    /**
     * ::::::::::::::::::::::::::::::::::::::
     * Check Location enabled or not
     * ::::::::::::::::::::::::::::::::::::::
     */
    if (!$request->session()->has('location_trace')) {
      $return['code'] = 101;
      $return['msg'] = 'Alert: Please enable your location.';

      return response()->json($return);
    }



    $trackSession = TrackSession::get();


    //check if running task available
    $taskCount = SeoExecutiveTask::where('user_id', $trackSession->userId())
      ->where('complete', 0)
      ->whereDate('start_time', date("Y-m-d"))
      ->count();


    if ($taskCount >= 1) {

      $return['code'] = 101;
      $return['msg'] = 'Alert: Your task is already running.';

      return response()->json($return);
    }


    $task_details = $request->input('task_details');

    $devtask = new SeoExecutiveTask();
    $devtask->user_id = $trackSession->userId();
    $devtask->start_time = date("Y-m-d H:i:s");
    $devtask->status = 0;
    $devtask->task = $task_details;
    $devtask->complete = 0;

    if ($devtask->save()) {


      /**
       * saving location info
       */
      $locationData = $request->session()->get('location_trace');
      $locationData = unserialize($locationData);

      TraceLocation::insert([
        'user_id' => $trackSession->userId(),
        'task_id' => $devtask->id,
        'work_type' => 'start',
        'latitude' => $locationData['latitude'],
        'longitude' => $locationData['longitude'],
        'ip' => $request->ip(),
        'date' => date('Y-m-d H:i:s')
      ]);


      $return['code'] = 200;
      $return['msg'] = 'Task started successfully.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }



  /**
   * :::::::::::::::::::::::::::::::::::::::::::
   * Finish Started Task
   * :::::::::::::::::::::::::::::::::::::::::::
   */
  public function finishTask(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'task_id' => "required",
        'task_remark' => "nullable|min:4",
        'status' => "nullable|numeric"
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    /**
     * ::::::::::::::::::::::::::::::::::::::
     * Check Location enabled or not
     * ::::::::::::::::::::::::::::::::::::::
     */
    if (!$request->session()->has('location_trace')) {
      $return['code'] = 101;
      $return['msg'] = 'Alert: Please enable your location.';

      return response()->json($return);
    }


    $trackSession = TrackSession::get();


    $task_id = $request->input('task_id');
    $task_id = Crypt::decryptString($task_id);


    $devtask = SeoExecutiveTask::find($task_id);


    if (empty($devtask)) {

      $return['code'] = 300;
      $return['msg'] = 'No Data';

      return response()->json($return);
    }


    $task_remark = $request->input('task_remark');
    $status = $request->input('status');


    $devtask->end_time = date("Y-m-d H:i:s");
    $devtask->status = $status;
    $devtask->remark = $task_remark;
    $devtask->complete = 1;

    if ($devtask->save()) {


      /**
       * saving location info
       */
      $locationData = $request->session()->get('location_trace');
      $locationData = unserialize($locationData);

      TraceLocation::insert([
        'user_id' => $trackSession->userId(),
        'task_id' => $devtask->id,
        'work_type' => 'finish',
        'latitude' => $locationData['latitude'],
        'longitude' => $locationData['longitude'],
        'ip' => $request->ip(),
        'date' => date('Y-m-d H:i:s')
      ]);

      $return['code'] = 200;
      $return['msg'] = 'Task finished successfully.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }



  /**
   * :::::::::::::::::::::::::::::::::::::::::::
   * Get Today Task List
   * :::::::::::::::::::::::::::::::::::::::::::
   */
  public function getTodayTaskList(Request $request)
  {

    $trackSession = TrackSession::get();

    //check if running task available
    $taskList = SeoExecutiveTask::where('user_id', $trackSession->userId())
      ->whereDate('start_time', date("Y-m-d"))
      ->orderBy('id', 'DESC')
      ->get();

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
    $isTaskActive = false;

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
      } else {

        $dateDiffObj->calculate($row->start_time, date('Y-m-d H:i:s'));

        $totHours += $dateDiffObj->getHr();
        $totMinutes += $dateDiffObj->getMin();
        $totSeconds += $dateDiffObj->getSec();

        $isTaskActive = true;
      }

      //calculate total working hours
      DateDiffCalculator::calHrMinSec($totHours, $totMinutes, $totSeconds);


      $retData[] = [
        'task_id' => Crypt::encryptString($row->id),
        'date' => date("Y-m-d", strtotime($row->start_time)),
        'start_time' => date("h:i:s A", strtotime($row->start_time)),
        'end_time' => $end_time,
        'task' => $row->seoTaskList->task,
        // 'task' => $row->task,
        'remark' => $row->remark,
        'status' => $status,
        'total_time' => $total_time,
        'action' => $action,
      ];
    }



    $return['total_working_hours'] = DateDiffCalculator::getToTimeFormat($totHours, $totMinutes, $totSeconds);
    $return['total_working_hours_arr'] = [$totHours, $totMinutes, $totSeconds];
    $return['is_task_active'] = $isTaskActive;


    $return['code'] = 200;
    $return['msg'] = 'Data found.';
    $return['data'] = $retData;
    $return['token'] = csrf_token();


    return response()->json($return);
  }
}
