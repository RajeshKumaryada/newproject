<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Options;
use App\Models\SeoTaskList;
use App\Models\SeoWorkReport;
use App\Models\SeoWorkReportDuplicateUrl;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SeoWorkDuplicateURLCtrl extends Controller
{

  /**
   * View for SEO Work Duplicate URLs 
   */
  public function viewDuplicateUrl()
  {
    return view('admin.work_report.seo_work_report_duplicate_url');
  }


  /**
   * AJAX call
   * fetch record of not viewed URLs
   */
  public function viewDuplicateUrlData()
  {
    $opTbl = Options::where('opt_key', 'last_seen_duplicate_url_report_id')->first();

    if (empty($opTbl)) {
      $lastSeen = 0;
    } else {
      $lastSeen = $opTbl->opt_value;
    }

    $urlData = SeoWorkReportDuplicateUrl::select('seo_wr_duplicate_url.*', 'seo_work_report.*', 'seo_task_list.task', 'seo_task_list.exclude_from_url_check', 'users.username as emp_name', 'emp_designation.des_name')
      ->leftJoin('seo_work_report', 'seo_wr_duplicate_url.work_report_id', 'seo_work_report.id')
      ->leftJoin('seo_task_list', 'seo_work_report.task_id', 'seo_task_list.id')
      ->leftJoin('users', 'seo_wr_duplicate_url.user_id', 'users.user_id')
      ->leftJoin('emp_designation', 'users.designation', 'emp_designation.des_id')
      ->where('seo_wr_duplicate_url.id', '>', $lastSeen)
      ->orderBy('seo_wr_duplicate_url.id', 'asc')
      ->get();



    if (!empty($urlData)) {

      $lastSeenId = SeoWorkReportDuplicateUrl::select('id')->orderBy('seo_wr_duplicate_url.id', 'desc')->first();

      $return['last_seen_id'] = $lastSeenId->id;

      $return['code'] = 200;
      $return['msg'] = "success";
      $return['data'] = $urlData;
    } else {
      $return['code'] = 204;
      $return['msg'] = "No Data";
    }




    return response()->json($return);
  }


  /**
   * AJAX call
   * fetch record of more urls
   */
  public function viewDuplicateUrlDataMore(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'value' => "required"
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $value = $request->input('value');
    $value = explode(',', $value);

    if (count($value) !== 3) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = ['value' => ['Invalid values.']];

      return response()->json($return);
    }

    $urlData = SeoWorkReport::select('seo_wr_duplicate_url.reason', 'seo_work_report.*', 'seo_task_list.task', 'seo_task_list.exclude_from_url_check')
      ->leftJoin('seo_wr_duplicate_url', 'seo_work_report.id', 'seo_wr_duplicate_url.work_report_id')
      ->leftJoin('seo_task_list', 'seo_work_report.task_id', 'seo_task_list.id')
      ->where('seo_work_report.id', '>', $value[0])
      ->where('seo_work_report.user_id', $value[1])
      ->where('seo_work_report.url', $value[2])
      ->orderBy('seo_work_report.id', 'asc')
      ->get();


    if (!empty($urlData)) {
      $return['code'] = 200;
      $return['msg'] = "success";
      $return['data'] = $urlData;
    } else {
      $return['code'] = 204;
      $return['msg'] = "No Data";
    }

    return response()->json($return);
  }


  /**
   * fetch records via form
   */
  public function viewDuplicateUrlDataForm(Request $request)
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

    $user =  $request->input('users');
    $task = $request->input('tasks');
    $start_date =  $request->input('start_date');
    $end_date = $request->input('end_date');

    // if ($user === "all") {
    //   $user = "";
    // } else {
    //   $user = " AND `t1`.`user_id` = {$user} ";
    // }



    // if ($task === "all") {
    //   $task = "";
    // } else {
    //   $task = " AND `t2`.`task` = {$task} ";
    // }


    $urlData = SeoWorkReportDuplicateUrl::select('seo_wr_duplicate_url.*', 'seo_work_report.*', 'seo_task_list.task', 'seo_task_list.exclude_from_url_check', 'users.username as emp_name', 'emp_designation.des_name')
      ->leftJoin('seo_work_report', 'seo_wr_duplicate_url.work_report_id', 'seo_work_report.id')
      ->leftJoin('seo_task_list', 'seo_work_report.task_id', 'seo_task_list.id')
      ->leftJoin('users', 'seo_wr_duplicate_url.user_id', 'users.user_id')
      ->leftJoin('emp_designation', 'users.designation', 'emp_designation.des_id')
      ->whereDate('seo_wr_duplicate_url.created_at', '>=', $start_date)
      ->whereDate('seo_wr_duplicate_url.created_at', '<=', $end_date);


    if ($user != "all") {
      $urlData = $urlData->where('seo_wr_duplicate_url.user_id', $user);
    }

    if ($task != "all") {
      $urlData = $urlData->where('seo_work_report.task_id', $task);
    }

    $urlData = $urlData->orderBy('seo_wr_duplicate_url.id', 'asc')->get();

    //   $sqlRes = $conn->query("SELECT `t1`.*, `t2`.*, `t3`.`task`, `t3`.`exclude_from_url_check`, `t4`.`username` as `emp_name`, `t5`.`d_name`
    // FROM `work_report_duplicate_url` t1 
    // LEFT JOIN `work_report` t2 ON `t1`.`work_report_id` = `t2`.`id` 
    // LEFT JOIN `task_list` t3 ON `t2`.`task` = `t3`.`id` 
    // LEFT JOIN `users` t4 ON `t1`.`user_id` = `t4`.`id`
    // LEFT JOIN `user_designation` t5 ON `t4`.`designation` = `t5`.`d_id`
    // WHERE ( DATE(`t1`.`created_at`) >= '{$start_date}' 
    // AND DATE(`t1`.`created_at`) <= '{$end_date}' )
    // {$user}
    // {$task} ORDER BY `wrd_id` ASC;");


    if (!empty($urlData)) {
      $return['code'] = 200;
      $return['msg'] = "success";
      $return['data'] = $urlData;
    } else {
      $return['code'] = 204;
      $return['msg'] = "No Data";
    }

    return response()->json($return);
  }



  /**
   * Update last seen new URLs
   */
  public function viewDuplicateUrlUpdateLastSeen(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'reset_id' => "required|numeric|max:999999999"
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $lastSeen = $request->input('reset_id');

    $update = Options::where('opt_key', 'last_seen_duplicate_url_report_id')
      ->update(['opt_value' => $lastSeen]);


    if ($update) {

      $return['code'] = 200;
      $return['msg'] = "success";

      return response()->json($return);
    }

    $return['code'] = 101;
    $return['msg'] = "Failed";

    return response()->json($return);
  }
}
