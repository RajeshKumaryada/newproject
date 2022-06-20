<?php

namespace App\Http\Controllers\Admin\Checklist;


use App\Http\Controllers\Controller;
use App\Models\ChecklistGroup;
use App\Models\ChecklistGroupUsers;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChecklistGroupCtrl extends Controller
{

  /**
   * 
   */
  public function viewCreateGroup()
  {

    $users = Users::where('user_id', '!=', 1)
      ->where('status', 1)
      ->orderBy('username', 'asc')->get();

    return view('admin.checklist.users_group', ['users' => $users]);
  }

  /**
   * save data to the table
   */
  public function createGroup(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'group_name' => "required|min:4|max:200|unique:checklist_group",
        'user_id' => "required"
      ]
    );


    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    $group_name = $request->input('group_name');
    $user_id = $request->input('user_id');


    $dataIn = [
      'group_name' => $group_name
    ];


    $insertId = ChecklistGroup::insertGetId($dataIn);

    if ($insertId > 0) {

      $dataIn = [];

      foreach ($user_id as $user) {
        $dataIn[] = [
          'checklist_group_id' => $insertId,
          'user_id' => $user
        ];
      }

      $insert = ChecklistGroupUsers::insert($dataIn);

      if ($insert == 1) {
        $return['code'] = 200;
        $return['msg'] = 'Checklist group created succesfully.';
      } else {
        $return['code'] = 101;
        $return['msg'] = 'Checklist group creation failed.';


        //delete table record, when insert failed in ChecklistGroupUsers table
        ChecklistGroup::where('checklist_group_id', $insertId)->delete();
      }
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Checklist group creation failed.';
    }


    return response()->json($return);
  }


  /**
   * Edit group
   */
  public function viewEditGroup($group_id)
  {

    $users = Users::where('user_id', '!=', 1)->orderBy('username', 'asc')->get();

    $groupInfo = ChecklistGroup::find($group_id);

    // $selectedUsers = ChecklistGroupUsers::where('checklist_group_id', $group_id)->get();

    $userIds = [];

    foreach ($groupInfo->groupUsers as $row) {
      $userIds[] = $row->user_id;
    }

    return view('admin.checklist.users_group_edit', ['users' => $users, 'groupInfo' => $groupInfo, 'userIds' => $userIds]);
  }



  /**
   * save data to the table
   */
  public function saveEditGroup(Request $request)
  {

    $group_id = $request->input('group_id');

    $validator = Validator::make(
      $request->all(),
      [
        'group_id' => "required|numeric|max:9999999999",
        'group_name' => "required|min:4|max:200|unique:checklist_group,group_name,{$group_id},checklist_group_id",
        'user_id' => "nullable"
      ]
    );


    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }



    $user_id = $request->input('user_id');

    $group_name = $request->input('group_name');


    $groupInfo = ChecklistGroup::find($group_id);
    $groupInfo->group_name = $group_name;



    if ($groupInfo->isDirty()) {
      $groupInfo->save();

      $return['code'] = 200;
      $return['msg'] = 'Checklist group updated succesfully.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'No changes have been made.';
    }



    if (!empty($user_id) && is_array($user_id)) {

      $dataIn = [];


      foreach ($user_id as $user) {
        $dataIn[] = [
          'checklist_group_id' => $group_id,
          'user_id' => $user
        ];
      }

      $insert = ChecklistGroupUsers::insert($dataIn);

      if ($insert == 1) {
        $return['code'] = 200;
        $return['msg'] = 'Checklist group updated succesfully.';
      } else {
        $return['code'] = 101;
        $return['msg'] = 'Checklist group updation failed.';
      }
    }




    return response()->json($return);
  }


  /**
   * fetch data from table
   */
  public function fetchCreateGroup()
  {

    $groups = ChecklistGroup::with(['groupUsers.username'])
      ->get();


    $return['code'] = 200;
    $return['msg'] = 'success';
    $return['data'] = $groups;

    return response()->json($return);
  }



  /**
   * fetch Group Users
   */
  public function fetchGroupUsers($group_id)
  {
    $groups = ChecklistGroupUsers::with(['username'])->where('checklist_group_id', $group_id)->get();

    $return['code'] = 200;
    $return['msg'] = 'success';
    $return['data'] = $groups;

    return response()->json($return);
  }






  /**
   * delete group
   */
  public function deleteCreateGroup(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'group_id' => "required|numeric|max:9999999999"
      ]
    );


    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $groupId = $request->input('group_id');

    $group = ChecklistGroup::find($groupId);

    if (!empty($group)) {
      $group->delete();

      ChecklistGroupUsers::where('checklist_group_id', $groupId)->delete();

      $return['code'] = 200;
      $return['msg'] = 'Checklist group deleted succesfully.';
    } else {
      $return['code'] = 100;
      $return['msg'] = 'Checklist group deletion failed.';
    }

    return response()->json($return);
  }


  /**
   * Delete group users
   */
  public function deleteGroupUsers(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'group_id' => "required|max:9999999999"
      ]
    );


    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    $groupId = $request->input('group_id');

    $group = ChecklistGroupUsers::find($groupId);

    if (!empty($group)) {
      $group->delete();

      $return['code'] = 200;
      $return['msg'] = 'Checklist group deleted succesfully.';
    } else {
      $return['code'] = 100;
      $return['msg'] = 'Checklist group deletion failed.';
    }

    return response()->json($return);
  }
}
