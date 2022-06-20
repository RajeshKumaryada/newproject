<?php

namespace App\Http\Controllers\ContentOnDemand\Admin;

use App\Classes\AddNotificationForContent;
use App\Http\Controllers\Controller;
use App\Models\NewContentTask;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RequestNewContentCtrl extends Controller
{

  /**
   * View form for demand new content by seo
   */
  public function viewReqNewContent()
  {

    $users = Users::orderBy('post', 'ASC')
      ->where('status', 1)
      ->orderBy('username', 'ASC')
      ->get();

    return view('content_on_demand.admin.request_new_content_form', ['users' => $users]);
  }


  /**
   * View form for demand new content by seo
   */
  public function saveReqNewContent(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'content_title' => 'required',
        'request_by' => 'required|numeric|min:1',
        'word_counts' => 'required|numeric|min:1',
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
    //need to ADD from form


    $insert = NewContentTask::insert([
      'request_by' => $request->input('request_by'),
      'title' => $request->input('content_title'),
      'word_count' => $request->input('word_counts'),
      'description' => htmlspecialchars($request->input('description')),
      'status' => 1, //assigned
      'request_date' => date("Y-m-d H:i:s")
    ]);



    if ($insert) {


      //assign notification to content team leader
      $addNoti = new AddNotificationForContent();
      $addNoti->toLeaders($request->input('request_by'));


      $return['code'] = 200;
      $return['msg'] = 'New content request has accepted.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'New content request can\'t accepted. #_DBINER';
    }

    return response()->json($return);
  }
}
