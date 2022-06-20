<?php

namespace App\Http\Controllers\ShowChecklist;

use App\Classes\Checklist\ChecklistForUsers;
use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ShowChecklistCtrl extends Controller
{

  /**
   * Show checklist page
   */
  public function show()
  {

    $checklist = ChecklistForUsers::init()->find(TrackSession::get()->userId());

    if ($checklist->isEmpty())
      return redirect('/login-success');
      

    return view('show_checklist.checklist', ['checklist' => $checklist]);
  }


  /**
   * Verify checklist
   */
  public function verify(Request $request)
  {

    $rules = [];
    $rulesMsg = [];

    $trackSession = TrackSession::get();
    $checklist = ChecklistForUsers::init()->find($trackSession->userId());

    if ($checklist->isEmpty()) {
      $return['code'] = 101;
      $return['msg'] = 'Rules are disabled.';

      return response()->json($return);
    }


    //merging task rules
    foreach ($checklist as $row) {

      if ($row->checklist_type == "req") {
        $temp = ["checklist_{$row->checklist_id}" => "required"];
        $msgTemp = ["checklist_{$row->checklist_id}.required" => "Confirm '{$row->checklist_text}'"];
        $rules = array_merge($rules, $temp);
        $rulesMsg = array_merge($rulesMsg, $msgTemp);
      }
    }


    $validator = Validator::make(
      $request->all(),
      $rules,
      $rulesMsg
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $vars = serialize($request->except('_token'));
    $request->session()->put('checklist_verified', $vars);

    $return['code'] = 200;
    $return['msg'] = 'success';
    $return['url'] = url('') . "/login-success";

    return response()->json($return);
  }
}
