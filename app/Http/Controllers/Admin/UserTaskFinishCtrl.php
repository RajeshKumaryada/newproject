<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\BackOfficeTask;
use App\Models\ContentWriterTask;
use App\Models\DesignerTask;
use App\Models\DeveloperTask;
use App\Models\HumanResourceTask;
use App\Models\SeoExecutiveTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class UserTaskFinishCtrl extends Controller
{


  /**
   * Finish SEO task
   */
  public function seoTask(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'task_id' => "required",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    $task_id = $request->input('task_id');
    $task_id = Crypt::decryptString($task_id);

    $userTask = SeoExecutiveTask::where('id', $task_id)->where('complete', 0)->first();

    if (empty($userTask)) {

      $return['code'] = 300;
      $return['msg'] = 'No Data available in the database.';

      return response()->json($return);
    }

    $userTask->end_time = date("Y-m-d H:i:s");
    $userTask->status = 0;
    $userTask->remark = "This task finished by manager.";
    $userTask->complete = 1;

    if ($userTask->save()) {
      $return['code'] = 200;
      $return['msg'] = 'Task finished successfully.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }



  /**
   * Finish Developer task
   */
  public function developerTask(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'task_id' => "required",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $task_id = $request->input('task_id');
    $task_id = Crypt::decryptString($task_id);

    $userTask = DeveloperTask::where('id', $task_id)->where('complete', 0)->first();

    if (empty($userTask)) {

      $return['code'] = 300;
      $return['msg'] = 'No Data available in the database.';

      return response()->json($return);
    }

    $userTask->end_time = date("Y-m-d H:i:s");
    $userTask->status = 0;
    $userTask->remark = "This task finished by manager.";
    $userTask->complete = 1;

    if ($userTask->save()) {
      $return['code'] = 200;
      $return['msg'] = 'Task finished successfully.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }



  /**
   * Finish Content Writer task
   */
  public function contentWriterTask(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'task_id' => "required",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $task_id = $request->input('task_id');
    $task_id = Crypt::decryptString($task_id);

    $userTask = ContentWriterTask::where('id', $task_id)->where('complete', 0)->first();

    if (empty($userTask)) {

      $return['code'] = 300;
      $return['msg'] = 'No Data available in the database.';

      return response()->json($return);
    }

    $userTask->end_time = date("Y-m-d H:i:s");
    $userTask->status = 0;
    // $userTask->remark = "This task finished by manager.";
    $userTask->complete = 1;
    $userTask->file_link = "#";
    $userTask->word_count = 0;

    if ($userTask->save()) {
      $return['code'] = 200;
      $return['msg'] = 'Task finished successfully.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }




  /**
   * Finish designer task
   */
  public function designerTask(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'task_id' => "required",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $task_id = $request->input('task_id');
    $task_id = Crypt::decryptString($task_id);

    $userTask = DesignerTask::where('id', $task_id)->where('complete', 0)->first();

    if (empty($userTask)) {

      $return['code'] = 300;
      $return['msg'] = 'No Data available in the database.';

      return response()->json($return);
    }

    $userTask->end_time = date("Y-m-d H:i:s");
    $userTask->status = 0;
    $userTask->remark = "This task finished by manager.";
    $userTask->complete = 1;

    if ($userTask->save()) {
      $return['code'] = 200;
      $return['msg'] = 'Task finished successfully.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }



  /**
   * Finish HR task
   */
  public function humanResourceTask(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'task_id' => "required",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $task_id = $request->input('task_id');
    $task_id = Crypt::decryptString($task_id);

    $userTask = HumanResourceTask::where('id', $task_id)->where('complete', 0)->first();

    if (empty($userTask)) {

      $return['code'] = 300;
      $return['msg'] = 'No Data available in the database.';

      return response()->json($return);
    }

    $userTask->end_time = date("Y-m-d H:i:s");
    $userTask->status = 0;
    $userTask->remark = "This task finished by manager.";
    $userTask->complete = 1;

    if ($userTask->save()) {
      $return['code'] = 200;
      $return['msg'] = 'Task finished successfully.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }


  /**
   * Finish designer task
   */
  public function backOfficeTask(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'task_id' => "required",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $task_id = $request->input('task_id');
    $task_id = Crypt::decryptString($task_id);

    $userTask = BackOfficeTask::where('id', $task_id)->where('complete', 0)->first();

    if (empty($userTask)) {

      $return['code'] = 300;
      $return['msg'] = 'No Data available in the database.';

      return response()->json($return);
    }

    $userTask->end_time = date("Y-m-d H:i:s");
    $userTask->status = 0;
    $userTask->remark = "This task finished by manager.";
    $userTask->complete = 1;

    if ($userTask->save()) {
      $return['code'] = 200;
      $return['msg'] = 'Task finished successfully.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }
}
