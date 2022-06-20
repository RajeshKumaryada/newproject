<?php

namespace App\Http\Controllers\ContentOnDemand\Writer;

use App\Classes\TrackSession;
use App\Classes\Variables\EditContentStatus;
use App\Http\Controllers\Controller;
use App\Models\NewContentRemarks;
use App\Models\NewContentTask;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WriterTeamMemberCtrl extends Controller
{
  /**
   * List of assigned content to the writers
   */
  public function viewTaskList()
  {
    return view('content_on_demand.writer.assigned_task_list');
  }


  public function fetchTaskList()
  {
    $userId = TrackSession::get()->userId();

    $taskList = NewContentTask::with('requestByUser')
      ->where('assign_to', $userId)
      // ->where('status', 1)
      ->orderBy('request_date', 'DESC')
      ->get();


    $contentStatus = EditContentStatus::get();

    //convert status code to string
    foreach ($taskList as $row) {
      $row->status = $contentStatus->value($row->status);
    }


    $return['code'] = 200;
    $return['msg'] = 'success';
    $return['data'] = $taskList;


    return response()->json($return);
  }




  /**
   * Fetch Content Remarks
   */
  public function fetchContentRemarks(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'id' => 'required|numeric:min:1|max:9999999999'
      ]
    );


    if ($validator->fails()) {
      $return['code'] = 101;
      $return['msg'] = $validator->errors()->get('id');

      return response()->json($return);
    }



    $remarks = NewContentRemarks::with(['userName'])
      ->where('new_content_id', $request->id)
      ->orderBy('remark_date', 'ASC')
      ->get();



    if ($remarks->isEmpty()) {
      $return['code'] = 101;
      $return['msg'] = 'No Remarks are available.';
    } else {
      $return['code'] = 200;
      $return['msg'] = 'Data found.';
      $return['data'] = $remarks;
    }


    return response()->json($return);
  }





  /**
   * submit Remark by SEO about the content
   */
  public function submitRemark(Request $request)
  {


    $validator = Validator::make(
      $request->all(),
      [
        'content_id' => 'required',
        'remark' => 'required',
        'help_url' => 'nullable|url'
      ]
    );


    if ($validator->fails()) {
      $return['code'] = 100;
      $return['msg'] = 'Error found';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    try {
      $contentId = decrypt($request->content_id);
    } catch (Exception $e) {
      $return['code'] = 101;
      $return['msg'] = 'Invalid Content ID.';

      return response()->json($return);
    }


    $insert = NewContentRemarks::insert([
      'new_content_id' => $contentId,
      'user_id' => TrackSession::get()->userId(),
      'user_type' => 'writer',
      'remark' => htmlspecialchars($request->remark),
      'help_url' => '',
      'remark_date' => date('Y-m-d H:i:s')
    ]);


    if ($insert > 0) {
      $return['code'] = 200;
      $return['msg'] = 'Remark submitted successfully.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Remark updation failed.';
    }


    return response()->json($return);
  }
}
