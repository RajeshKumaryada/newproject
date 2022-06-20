<?php

namespace App\Http\Controllers\WorkPortal\SeoExecutive;


use App\Http\Controllers\Controller;
use App\Models\SeoTaskList;
use App\Models\SeoWorkReport;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SeoVieWorkReportCtrl extends Controller
{

  /**
   * View Form
   */
  public function viewForm()
  {
    return view('work_portal.seo_executive.view_work_report');
  }


  /**
   * AJAX call
   * 
   * Get User List by Post (Position)
   */
  public function fetchUsersByPost()
  {

    $users = Users::select('user_id AS id', 'username AS value')
      ->where('post', 4)
      ->orderBy('username', 'ASC')
      ->get();


    if (empty($users)) {
      $return['code'] = 404;
      $return['msg'] = "No data found!";
      $return['data'] = null;

      return response()->json($return);
    }


    $return['code'] = 200;
    $return['data'] = $users;

    return response()->json($return);
  }



  /**
   * AJAX call
   * 
   * Get SEO Task List
   */
  public function fetchTaskList()
  {


    $res = SeoTaskList::select('id', 'task AS value')
      ->orderBy('task', 'ASC')
      ->get();


    if (empty($res)) {
      $return['code'] = 404;
      $return['msg'] = "No data found!";
      $return['data'] = null;

      return response()->json($return);
    }


    $return['code'] = 200;
    $return['data'] = $res;

    return response()->json($return);
  }


  /**
   * ::::::::::::::::::::::::::::::::::::::
   * Getting Task List for all users
   * :::::::::::::::::::::::::::::::::::::
   */
  public function fetchWorkReort(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'users' => "required",
        'tasks' => "required",
        'start_date' => "required|date",
        'end_date' => "required|date"
      ]
    );


    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    // $userType = $request->input('usertype');

    $users = $request->input('users');
    $tasks = $request->input('tasks');
    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    // print_r($users);
    // print_r($tasks);

    // exit();

    $taskListSummary = SeoWorkReport::with(['users:username,email,user_id'])
      ->whereIn('user_id', $users);

    if ($tasks[0] != 'all') {
      $taskListSummary = $taskListSummary->whereIn('task_id', $tasks);
    }

    $taskListSummary = $taskListSummary->whereDate('date', '>=', $start_date)
      ->whereDate('date', '<=', $end_date)
      ->select('user_id', DB::raw('count(user_id) as task_count'))
      // ->orderBy('user_id', 'asc')
      // ->orderBy('date', 'asc')
      ->groupBy('user_id')
      ->get();

    if ($taskListSummary->isEmpty()) {
      $return['code'] = 101;
      $return['msg'] = 'No Data Found';

      return response()->json($return);
    }


    $taskList = SeoWorkReport::with(['seoTaskList:task,id'])
      ->whereIn('user_id', $users);


    if ($tasks[0] != 'all') {
      $taskList = $taskList->whereIn('task_id', $tasks);
    }

    $taskList = $taskList->whereDate('date', '>=', $start_date)
      ->whereDate('date', '<=', $end_date)
      ->orderBy('user_id', 'asc')
      ->orderBy('date', 'asc')
      ->get();


    // $return['code'] = 20;
    // $return['msg'] = 'Data';
    // $return['data'] = [$taskListSummary, $taskList];

    // return response()->json($return);

    //check if running task available


    if (empty($taskList)) {

      $return['code'] = 100;
      $return['msg'] = 'No Data Found';

      return response()->json($return);
    }


    //getting on-page iamges
    // $taskImgList = SeoWorkReport::whereIn('user_id', $users);
    // if ($tasks[0] != 'all') {
    //   $taskImgList = $taskImgList->whereIn('task_id', $tasks);
    // }
    // $taskImgList = $taskImgList->whereDate('date', '>=', $start_date)
    //   ->whereDate('date', '<=', $end_date)
    //   ->whereNotNull('img_id')
    //   // ->orderBy('user_id', 'asc')
    //   // ->orderBy('date', 'asc')
    //   ->groupBy('img_id')
    //   ->get();




    $retData = [];


    foreach ($taskListSummary as $idx => $row) {

      $retData[$idx] = [
        'emp_id' => $row->user_id,
        'emp_name' => $row->users->username,
        'emp_email' => $row->users->email,
        'task_count' => $row->task_count
      ];


      $temp = [];

      foreach ($taskList as $idx2 => $row2) {
        if ($row2->user_id === $row->user_id) {

          $temp[] = [
            'date' => date('Y-m-d', strtotime($row2->date)),
            'time' => "",
            'task' => $row2->seoTaskList->task,
            'title' => $row2->title,
            'email' => $row2->email,
            'username' => $row2->username,
            // 'password' => (empty($row2->password)) ? '' : '********',
            'url' => $row2->url,
            // 'img_url' => (!empty($row2->img_id)) ? encrypt($row2->img_id) : "",
          ];

          unset($taskList[$idx2]);
        }
      }

      $retData[$idx]['user_data'] = $temp;
    }


    $return['code'] = 200;
    $return['msg'] = 'Data';
    $return['data'] = $retData;
    // $return['test'] = $taskImgList;

    return response()->json($return);
  }
}
