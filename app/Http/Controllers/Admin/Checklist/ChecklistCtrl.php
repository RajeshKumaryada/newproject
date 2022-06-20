<?php

namespace App\Http\Controllers\Admin\Checklist;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\ChecklistGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChecklistCtrl extends Controller
{
  /**
   * View form for creating check list
   */
  public function viewFormChecklist()
  {

    $checklistGroup = ChecklistGroup::orderBy('group_name', 'asc')->get();

    return view('admin.checklist.create_checklist', ['checklistGroup' => $checklistGroup]);
  }


  /**
   * Save new checklist info to DB
   */
  public function saveChecklistInfo(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'checklist_name' => "required|min:4|max:200|unique:checklist",
        'checklist_text' => "required|min:4|max:5000",
        'checklist_type' => "required|min:3|max:3",
        'checklist_group_id' => "required|numeric|max:9999999999",
        'status' => "required|numeric|min:1|max:10",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    $insert = Checklist::insert(
      [
        'checklist_name' => $request->input('checklist_name'),
        'checklist_text' => $request->input('checklist_text'),
        'checklist_type' => $request->input('checklist_type'),
        'checklist_group_id' => $request->input('checklist_group_id'),
        'status' => $request->input('status'),
      ]
    );


    if ($insert == 1) {
      $return['code'] = 200;
      $return['msg'] = 'Checklist created succesfully.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Checklist creatiuon failed.';
    }


    return response()->json($return);
  }



  /**
   * View form for creating check list
   */
  public function viewFormEditChecklist($checklist_id)
  {



    $checklist = Checklist::find($checklist_id);

    if (empty($checklist)) {
      return abort(404);
    }

    $checklistGroup = ChecklistGroup::orderBy('group_name', 'asc')->get();

    return view('admin.checklist.edit_checklist', ['checklist' => $checklist, 'checklistGroup' => $checklistGroup]);
  }



  /**
   * Save Edit form
   */
  public function saveEditChecklist(Request $request)
  {

    $checklistId = $request->input('checklist_id');

    $validator = Validator::make(
      $request->all(),
      [
        'checklist_id' => "required|numeric|max:9999999999",
        'checklist_name' => "required|min:4|max:200|unique:checklist,checklist_name,{$checklistId},checklist_id",
        'checklist_text' => "required|min:4|max:5000",
        'checklist_type' => "required|min:3|max:3",
        'checklist_group_id' => "required|numeric|max:9999999999",
        'status' => "required|numeric|min:1|max:10",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $checklist = Checklist::find($checklistId);

    if (!empty($checklist)) {
      $checklist->checklist_name = $request->input('checklist_name');
      $checklist->checklist_text = $request->input('checklist_text');
      $checklist->checklist_type = $request->input('checklist_type');
      $checklist->checklist_group_id = $request->input('checklist_group_id');
      $checklist->status = $request->input('status');

      if ($checklist->isDirty()) {
        $checklist->save();

        $return['code'] = 200;
        $return['msg'] = 'Checklist updated succesfully.';
      } else {
        $return['code'] = 101;
        $return['msg'] = 'No modifications found.';
      }
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Checklist not found.';
    }


    return response()->json($return);
  }



  /**
   * fetch data from table
   */
  public function fetchChecklistInfo()
  {

    $groups = Checklist::with(['checklistGroup'])
      ->get();


    $return['code'] = 200;
    $return['msg'] = 'success';
    $return['data'] = $groups;

    return response()->json($return);
  }


  /**
   * Delete check list info
   */
  public function deleteChecklistInfo(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'checklist_id' => "required|numeric|max:9999999999"
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    $checklistId = $request->input('checklist_id');

    $group = Checklist::find($checklistId);

    if (!empty($group)) {
      $group->delete();

      $return['code'] = 200;
      $return['msg'] = 'Checklist deleted succesfully.';
    } else {
      $return['code'] = 100;
      $return['msg'] = 'Checklist deletion failed.';
    }

    return response()->json($return);
  }
}
