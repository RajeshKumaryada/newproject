<?php

namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;
use App\Models\SeoWorkReport;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LinkReportCtrl extends Controller
{

  /**
   * View for Link Report
   */
  public function viewSeoLinkReport()
  {
    return view('admin.link_report.seo_link_report');
  }


  /**
   * AJAX call
   * POST method
   * return Link count data
   */
  public function seoLinkReport(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'start_date' => "required|date|before:tomorrow",
      ],
      [
        'start_date.before' => "The date must be a same or before " . date('Y-m-d')
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    $date = $request->input('start_date');
    // $date = '2021-08-03';
    // $previousDate = date("Y-m-d", strtotime('-1 day', strtotime($date)));
    $retData = [];

    $userList = Users::where('post', 4)->where('status', 1)->orderBy('username', 'asc')->get();

    if (empty($userList)) {
      $return['code'] = 100;
      $return['msg'] = 'No Data Found';

      return response()->json($return);
    }

    foreach ($userList as $idx => $row) {

      $total_task = $row->seoWorkReport()->whereDate('date', $date)->count();

      
      if ($total_task <= 0)
        continue;


      $retData[$idx] = [
        'total_task' => $total_task,
        'user_id' => $row->user_id,
        'date' => $date,
        // 'previous_date' => $previousDate,
        'username' => $row->username,
        // 'total_task_previous' => $row->seoWorkReport()->whereDate('date', $previousDate)->count(),
        'total_research_links' => $row->seoWorkReport()->whereDate('date', $date)->where('task_id', 3)->count(),
      ];
    }


    //short array data link counts DESC
    array_multisort(array_column($retData, 'total_task'), SORT_DESC, $retData);

    $return['code'] = 200;
    $return['msg'] = 'Data found';
    $return['data'] = $retData;

    return response()->json($return);
  }


  /**
   * AJAX call
   * POST method
   * return Link count data
   */
  public function seoLinkDetails(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'date' => "required|date|before:tomorrow",
        'user_id' => "required|numeric|max:99999999",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $date = $request->input('date');
    $userId = $request->input('user_id');

    $workReport = SeoWorkReport::where('user_id', $userId)->whereDate('date', $date)->get();

    $taskNameList = [];
    $data = [];

    foreach ($workReport as $row) {

      $taskName =  $row->seoTaskList()->first()->task;

      //total links count task wise
      if (empty($taskNameList[$row->task_id])) {
        $taskNameList[$row->task_id]['task_count'] = 1;
        $taskNameList[$row->task_id]['task_name'] = $taskName;
      } else {
        $taskNameList[$row->task_id]['task_count'] += 1;
      }

      $row->task_name = $taskName;

      $data[] = $row;
    }



    $return['code'] = 200;
    $return['msg'] = 'Data found';
    $return['data'] = $data;
    $return['data_task_links'] = $taskNameList;

    // print_r($return);

    return response()->json($return);
  }
}
