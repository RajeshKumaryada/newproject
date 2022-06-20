<?php

namespace App\Http\Controllers\ContentOnDemand\Writer;

use App\Classes\ContentHoursCalculation;
use App\Classes\TrackSession;
use App\Classes\Variables\EditContentStatus;
use App\Http\Controllers\Controller;
use App\Models\NewContentEdits;
use App\Models\NewContentTask;
use App\Models\NewContentTimestamps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContentEditorCtrl extends Controller
{

  /**
   * Editor for content writes
   */
  public function viewForContentEditor($taskId)
  {

    //check if any running content task
    $runningTask = NewContentTask::where('status', 3)
      ->where('assign_to', TrackSession::get()->userId())
      ->where('id', '<>', $taskId)
      ->count();

    // if ($runningTask > 0) {
    //   return view('content_on_demand.writer.error_already_running_task');
    // }

    if ($runningTask > 0) {
      echo "<script>alert('Task already running ,only one task run at a time.')</script>
      <script>var ww = window.open(window.location, '_self'); ww.close();</script>";
      
      // return redirect('content-writer/content/assigned/list');
    }


    //getting content information
    $taskInfo = NewContentTask::find($taskId);


    if (empty($taskInfo)) {
      return abort(404);
    }



    $contentStatus = EditContentStatus::get();

    //convert status code to string
    $taskInfo->status = $contentStatus->value($taskInfo->status);


    //getting and calculating total time taken on the content
    $hoursArr = [
      'work_hours' => 0,
      'work_hours_arr' => 0,
    ];
    $timestamps = [];

    if (!empty($taskInfo->contentEdits)) {
      $timestamps = $taskInfo->contentEdits->contentTimestamps;
      $hoursCalculation = new ContentHoursCalculation();
      $hoursArr = $hoursCalculation->calculate($timestamps);
    }


    return view('content_on_demand.writer.content_editor', ['taskInfo' => $taskInfo, 'hoursArr' => $hoursArr, 'timestamps' => $timestamps]);
  }


  /**
   * Start content editing on Editor
   */
  public function startEditing(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'content_id' => 'required',
      ]
    );

    if ($validator->fails()) {
      $return['code'] = 101;
      $return['msg'] = $validator->errors()->get('content_id');

      return response()->json($return);
    }


    $contentId = decrypt($request->input('content_id'));

    $contentInfo = NewContentTask::find($contentId);

    if (empty($contentInfo)) {
      $return['code'] = 101;
      $return['msg'] = 'Invalid content ID.';

      return response()->json($return);
    }

    if ($contentInfo->status == 5) {
      $return['code'] = 101;
      $return['msg'] = 'You can\'t edit this content until re-assigned it to you.';

      return response()->json($return);
    }

    $contentInfo->status = 3;
    // $contentInfo->updated_date = date('Y-m-d H:i:s');

    if ($contentInfo->save()) {

      //check in content_edits table
      $contentEdits = NewContentEdits::where('new_content_id', $contentId)->first();


      if (empty($contentEdits)) {
        //if not entry insert the record
        $contentEditsId = NewContentEdits::insertGetId(['new_content_id' => $contentId, 'content' => '']); //, 'status' => 3
      } else {
        $contentEditsId = $contentEdits->id;
      }

      //insert edit time
      $contentTimestampsId = NewContentTimestamps::insertGetId(['new_content_edits_id' => $contentEditsId, 'start_time' => date('Y-m-d H:i:s')]);

      //create arrray to store in the session
      request()->session()->put(
        'cw_edits_info',
        serialize([
          'contentId' => $contentId,
          'contentEditsId' => $contentEditsId,
          'contentTimestampsId' => $contentTimestampsId,
        ])
      );

      $return['code'] = 200;
      $return['msg'] = 'Task started succesfully.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Save data error. #DBINER';
    }

    return response()->json($return);
  }



  /**
   * Save/finish content to database
   */
  public function saveFinalContent(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        // 'content_id' => 'required',
        'content' => 'required',
      ]
    );

    if ($validator->fails()) {
      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }



    if (!(request()->session()->has('cw_edits_info'))) {
      $return['code'] = 101;
      $return['msg'] = "Invalid Session for Content Editor.";

      return response()->json($return);
    }


    // $contentId = decrypt($request->input('content_id'));
    // $content = $request->input('content');

    $session = unserialize(request()->session()->get('cw_edits_info'));
    $contentId = $session['contentId'];


    $contentEdit = NewContentEdits::where('new_content_id', $contentId)->first();




    if (empty($contentEdit)) {


      $return['code'] = 101;
      $return['msg'] = 'Invalid content ID.';

      return response()->json($return);
    }


    $contentEdit->content = $this->filterContent($request->content);



    if ($contentEdit->save()) {


      // NewContentTask::where('id', $contentId)->update(['status' => 5, 'updated_date' => date('Y-m-d H:i:s')]);
      NewContentTask::where('id', $contentId)->update(['status' => 5]);

      $contentTimestampsId = $session['contentTimestampsId'];
      NewContentTimestamps::where('id', $contentTimestampsId)->update(['end_time' => date('Y-m-d H:i:s')]);

      request()->session()->forget('cw_edits_info');

      $return['code'] = 200;
      $return['msg'] = 'Content has been saved.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'No changes are found.';
    }


    return response()->json($return);
  }



  /**
   * Auto Save Content
   */
  public function autoSaveContent(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'content' => 'required',
      ]
    );

    if ($validator->fails()) {
      $return['code'] = 101;
      $return['msg'] = $validator->errors()->get('content');

      return response()->json($return);
    }


    if (!(request()->session()->has('cw_edits_info'))) {
      $return['code'] = 101;
      $return['msg'] = "Invalid Session for Content Editor.";

      return response()->json($return);
    }


    // $content = $request->input('content');


    $session = unserialize(request()->session()->get('cw_edits_info'));
    $contentId = $session['contentId'];


    $contentEdit = NewContentEdits::where('new_content_id', $contentId)->first();

    if (empty($contentEdit)) {
      $return['code'] = 101;
      $return['msg'] = "Invalid Content ID.";

      return response()->json($return);
    }


    $contentEdit->content = $this->filterContent($request->content);


    if ($contentEdit->isDirty()) {


      if ($contentEdit->save()) {

        $contentTimestampsId = $session['contentTimestampsId'];
        NewContentTimestamps::where('id', $contentTimestampsId)->update(['end_time' => date('Y-m-d H:i:s')]);


        //getting and calculating total time taken on the content
        $hoursArr = [
          'work_hours' => 0,
          'work_hours_arr' => 0,
        ];
        $timestamps = [];

        if (!empty($timestamps = $contentEdit->contentTimestamps)) {
          $hoursCalculation = new ContentHoursCalculation();
          $hoursArr = $hoursCalculation->calculate($timestamps);
        }

        $return['code'] = 200;
        $return['msg'] = 'Content auto saved.';
        $return['hoursArr'] = $hoursArr;
        $return['timestamps'] = $timestamps;
      }
    } else {
      $return['code'] = 101;
      $return['msg'] = 'No changes are found.';
    }

    return response()->json($return);
  }



  /**
   * Draft Save Content
   */
  public function draftSaveContent(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'content' => 'required',
      ]
    );

    if ($validator->fails()) {
      $return['code'] = 101;
      $return['msg'] = $validator->errors()->get('content');

      return response()->json($return);
    }


    if (!(request()->session()->has('cw_edits_info'))) {
      $return['code'] = 101;
      $return['msg'] = "Invalid Session for Content Editor.";

      return response()->json($return);
    }


    // $content = $request->input('content');


    $session = unserialize(request()->session()->get('cw_edits_info'));
    $contentId = $session['contentId'];


    $contentEdit = NewContentEdits::where('new_content_id', $contentId)->first();

    if (empty($contentEdit)) {
      $return['code'] = 101;
      $return['msg'] = "Invalid Content ID.";

      return response()->json($return);
    }


    $contentEdit->content = $this->filterContent($request->content);


    if ($contentEdit->save()) {

      NewContentTask::where('id', $contentId)->update(['status' => 4]);



      $contentTimestampsId = $session['contentTimestampsId'];
      NewContentTimestamps::where('id', $contentTimestampsId)->update(['end_time' => date('Y-m-d H:i:s')]);

      request()->session()->forget('cw_edits_info');

      $return['code'] = 200;
      $return['msg'] = 'Content saved as Draft.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'No changes are found.';
    }

    return response()->json($return);
  }



  /**
   * Filter the content
   */
  private function filterContent($content)
  {

    $find = ['<form', '</form>', '<input', '<select', '</select>', '<option', '</option>', '<textarea', '</textarea>', '<iframe', '</iframe>', '<html', '</html>', '<body', '</body>', '<script', '</script>', '<link', '<meta', '<optgroup', '</optgroup>'];

    $content = str_replace($find, '', $content);

    return htmlspecialchars($content);
  }
}
