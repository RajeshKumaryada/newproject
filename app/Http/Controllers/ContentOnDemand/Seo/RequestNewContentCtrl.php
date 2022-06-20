<?php

namespace App\Http\Controllers\ContentOnDemand\Seo;

use App\Classes\AddNotificationForContent;
use App\Classes\ContentHoursCalculation;
use App\Classes\Functions\Fns;
use App\Classes\TrackSession;
use App\Classes\Variables\EditContentStatus;
use App\Http\Controllers\Controller;
use App\Models\NewContentRemarks;
use App\Models\NewContentTask;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RequestNewContentCtrl extends Controller
{

  /**
   * View form for demand new content by seo
   */
  public function viewDemandNewBySeo()
  {
    return view('content_on_demand.seo.request_new_content_form');
  }


  /**
   * View form for demand new content by seo
   */
  public function saveDemandNewBySeo(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'content_title' => 'required',
        'word_counts' => 'required|numeric',
        'description' => 'required'
      ]
    );

    if ($validator->fails()) {
      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }





    //getting user_id of the requested user
    $requestBy = TrackSession::get()->userId();


    $insert = NewContentTask::insert([
      'request_by' => $requestBy,
      'title' => $request->input('content_title'),
      'word_count' => $request->input('word_counts'),
      'description' => htmlspecialchars($request->input('description')),
      'status' => 1, //Requested by seo
      'request_date' => date("Y-m-d H:i:s")
    ]);



    if ($insert) {

      //assign notification to content team leader
      $addNoti = new AddNotificationForContent();
      $addNoti->toLeaders($requestBy);



      $return['code'] = 200;
      $return['msg'] = 'New content request has accepted.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'New content request can\'t accepted. #_DBINER';
    }

    return response()->json($return);
  }



  /**
   * Requested content list
   */
  public function viewRequestedContentList()
  {
    return view('content_on_demand.seo.requested_content_list');
  }



  /**
   * fetch assign content data
   */
  public function fetchRequestedContentList()
  {
    $content = NewContentTask::with('requestByUser', 'assignToUser')
      ->where('request_by', TrackSession::get()->userId())
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
   * Requested content list
   */
  public function viewContentPreview($pId)
  {

    $content = NewContentTask::where('status', '>=', 3)
      ->where('request_by', TrackSession::get()->userId())
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

    return view('content_on_demand.seo.content_previrw', ['content' => $content, 'hoursArr' => $hoursArr, 'timestamps' => $timestamps]);
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
      ->where('request_by', TrackSession::get()->userId())
      ->where('id', $contentId)
      ->first();


    $content->status_str = EditContentStatus::get()->value($content->status);
    $content->contentEdits->content = htmlspecialchars_decode($content->contentEdits->content);
    $content->contentEdits->status = $content->status_str;
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


    //find content information
    $contentInfo = NewContentTask::where('status', '>', 2)->where('id', $contentId)->first();

    if (!empty($contentInfo)) {

      $contentInfo->status = 6;

      if ($contentInfo->save()) {
        //send notification to content team leader and writer
        $addNotification = new AddNotificationForContent();
        $addNotification->forChangeRequest(TrackSession::get()->userId(), $contentInfo->assign_to);
      }
    }


    $insert = NewContentRemarks::insert([
      'new_content_id' => $contentId,
      'user_id' => TrackSession::get()->userId(),
      'user_type' => 'seo',
      'remark' => htmlspecialchars($request->remark),
      'help_url' => $request->help_url,
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
}
