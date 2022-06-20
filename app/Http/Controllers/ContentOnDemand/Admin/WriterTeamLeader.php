<?php

namespace App\Http\Controllers\ContentOnDemand\Admin;

use App\Classes\AddNotificationForContent;
use App\Classes\ContentHoursCalculation;
use App\Classes\Functions\Fns;
use App\Classes\TrackSession;
use App\Classes\Variables\EditContentStatus;
use App\Http\Controllers\Controller;
use App\Models\NewContentRemarks;
use App\Models\NewContentTask;
use App\Models\Users;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WriterTeamLeader extends Controller
{

  /**
   * view for assign content vai
   * content team leader
   */
  public function viewAssignContent()
  {
    return view('content_on_demand.admin.requested_content_list');
  }






  /**
   * fetch assign content data
   */
  public function fetchRequestedContentList()
  {


    $content = NewContentTask::with('requestByUser', 'assignToUser')
      ->orderBy('request_date', 'DESC')
      ->get();


    $contentStatus = EditContentStatus::get();

    //convert status code to string
    foreach ($content as $row) {
      $row->status_str = $contentStatus->value($row->status);
    }


    $return['code'] = 200;
    $return['msg'] = 'Data found.';
    $return['data'] = $content;

    return response()->json($return);
  }




  /**
   * view for assign content vai
   * content team leader
   */
  public function viewEditAssignContent($contentId)
  {


    $contentInfo = NewContentTask::find($contentId);

    //fetch writer users
    $seoUsers = Users::select('user_id', 'username')
      ->where('post', 1)
      ->where('status', 1)
      ->orderBy('username', 'asc')
      ->get();

    return view('content_on_demand.admin.assign_content_to_writer', ['contentInfo' => $contentInfo, 'seoUsers' => $seoUsers]);
  }


  /**
   * Assign Content to Writer by Writer Team 
   */
  public function assignContentToWriter(Request $request)
  {


    $validator = Validator::make(
      $request->all(),
      [
        'content_id' => 'required',
        'assign_to' => 'required|numeric',
        'help_url' => 'nullable|url',
        'remark' => 'nullable'
      ]
    );

    if ($validator->fails()) {
      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    //getting cintent ID
    $contentId = $request->input('content_id');
    $contentId = decrypt($contentId);


    //check and get the content information
    $newContentTask = NewContentTask::find($contentId);

    if (empty($newContentTask)) {

      $return['code'] = 101;
      $return['msg'] = 'Incorrect Content ID.';

      return response()->json($return);
    }


    $newContentTask->assign_to = $request->input('assign_to');
    $newContentTask->assign_date = date('Y-m-d H:i:s');
    $newContentTask->status = 2;

    if ($newContentTask->save()) {


      //insert record into remark table
      //need to update, every time insert value
      NewContentRemarks::insert([
        'new_content_id' => $newContentTask->id,
        'user_id' => TrackSession::getAdmin()->userId(),
        'user_type' => 'leader',
        'remark' => $request->input('remark'),
        'help_url' => $request->input('help_url'),
        'remark_date' => date('Y-m-d H:i:s'),
      ]);


      //assign notification to content writer
      $addNoti = new AddNotificationForContent();
      $addNoti->toWriter($request->input('assign_to'));


      $return['code'] = 200;
      $return['msg'] = 'Task assigned successfully.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Task assignment failed. #DBINER';
    }

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
   * Requested content list
   */
  public function viewContentPreview($pId)
  {


    $content = NewContentTask::where('status', '>=', 3)
      // ->where('request_by', TrackSession::get()->userId())
      ->where('id', $pId)
      ->first();



    if (empty($content)) {
      return abort(404);
    }


    $content->status_str = EditContentStatus::get()->value($content->status);


    //getting and calculating total time taken on the content
    $hoursArr = [
      'work_hours' => 0,
      'work_hours_arr' => 0,
    ];
    $timestamps = null;

    if (!empty($timestamps = $content->contentEdits->contentTimestamps)) {
      $hoursCalculation = new ContentHoursCalculation();
      $hoursArr = $hoursCalculation->calculate($timestamps);
    }


    return view('content_on_demand.admin.content_previrw', ['content' => $content, 'hoursArr' => $hoursArr, 'timestamps' => $timestamps]);
  }



  /**
   * Get Content Preview 
   */
  public function getContentPreview(Request $request)
  {



    $validator = Validator::make(
      $request->all(),
      [
        'content_id' => 'required'
      ]
    );


    if ($validator->fails()) {
      $return['code'] = 101;
      $return['msg'] = $validator->errors()->get('content_id');

      return response()->json($return);
    }


    $contentId = $request->input('content_id');

    try {
      $contentId = decrypt($contentId);
    } catch (Exception $e) {
      $return['code'] = 101;
      $return['msg'] = 'Invalid Content ID.';

      return response()->json($return);
    }



    $content = NewContentTask::with(['assignToUser', 'contentEdits.timeLastUpdate'])
      ->where('status', '>=', 3)
      // ->where('request_by', TrackSession::get()->userId())
      ->where('id', $contentId)
      ->first();


    $content->status_str = EditContentStatus::get()->value($content->status);
    $content->contentEdits->content = htmlspecialchars_decode($content->contentEdits->content);
    $content->done_word_count = Fns::init()->wordCount($content->contentEdits->content);


    //getting and calculating total time taken on the content
    $hoursArr = [
      'work_hours' => 0,
      'work_hours_arr' => 0,
    ];
    $timestamps = [];

    if (!empty($timestamps = $content->contentEdits->contentTimestamps)) {
      $hoursCalculation = new ContentHoursCalculation();
      $hoursArr = $hoursCalculation->calculate($timestamps);
    }



    $return['code'] = 200;
    $return['msg'] = 'Data found.';
    $return['data'] = $content;
    $return['hoursArr'] = $hoursArr;
    $return['timestamps'] = $timestamps;


    return response()->json($return);
  }



  /**
   * submit Remark by content Leader
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
      'user_id' => TrackSession::getAdmin()->userId(),
      'user_type' => 'leader',
      'remark' => htmlspecialchars($request->remark),
      'help_url' => $request->help_url,
      'remark_date' => date('Y-m-d H:i:s')
    ]);


    if ($insert > 0) {

      $data = NewContentTask::find($contentId);
      $data->status = 2;
      $data->save();

      $return['code'] = 200;
      $return['msg'] = 'Remark submitted successfully.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Remark updation failed.';
    }


    return response()->json($return);
  }




  /**
   * Delete Content request by SEOs
   */
  public function deleteRequestedContent(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'id' => 'required|numeric|min:1',
      ]
    );


    if ($validator->fails()) {
      $return['code'] = 101;
      $return['msg'] = $validator->errors()->get('id');

      return response()->json($return);
    }


    $content = NewContentTask::find($request->id);

    if (empty($content)) {
      $return['code'] = 101;
      $return['msg'] = "Invalid Content ID.";

      return response()->json($return);
    }



    if ($content->status != 1) {
      $return['code'] = 101;
      $return['msg'] = "This Content Request can't be deleted after assigned.";

      return response()->json($return);
    } else {

      //delete only requested content

      if ($content->delete()) {
        $return['code'] = 200;
        $return['msg'] = "Content Request has been deleted.";
      } else {
        $return['code'] = 101;
        $return['msg'] = "Delete Request for Content is failed. Er:DBDEL";
      }



      return response()->json($return);
    }
  }




  /**
   * Approve Content
   */
  public function approveContent(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'id' => 'required|numeric|min:1',
      ]
    );


    if ($validator->fails()) {
      $return['code'] = 101;
      $return['msg'] = $validator->errors()->get('id');

      return response()->json($return);
    }


    $content = NewContentTask::where('status', 5)
      ->where('id', $request->id)
      ->first();


    if (empty($content)) {
      $return['code'] = 101;
      $return['msg'] = "Only Unapproved content can be Approved.";

      return response()->json($return);
    }


    //approved
    $content->status = 7;

    if ($content->save()) {
      $return['code'] = 200;
      $return['msg'] = "Content has been Approved.";
    } else {
      $return['code'] = 101;
      $return['msg'] = "Content approve action failed. ErDBUP";
    }

    return response()->json($return);
  }
}
