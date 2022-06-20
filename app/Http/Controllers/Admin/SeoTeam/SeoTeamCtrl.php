<?php

namespace App\Http\Controllers\Admin\SeoTeam;

use App\Classes\Variables\WorkTeamType;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\WorkTeamInfo;
use App\Models\WorkTeamMembers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeoTeamCtrl extends Controller
{

  /**
   * View for Seo Team info summary
   */
  public function viewSeoTeam()
  {

    //where('team_type', WorkTeamType::get()->key('SEO Sales'))

    $teamInfo = WorkTeamInfo::orderBy('team_type', 'asc')
      ->orderBy('team_name', 'asc')
      ->get();


    //selecting content writers
    $contentWriters = Users::where('post', 1)
      ->where('status', 1)
      ->orderBy('username', 'asc')
      ->get();


    $workTeamType = WorkTeamType::get();

    return view('admin.seo_team.seo_team_info', ['teamInfo' => $teamInfo, 'contentWriters' => $contentWriters, 'workTeamType' => $workTeamType]);
  }


  /**
   * View for create team
   */
  public function viewCreateTeam()
  {

    $users = Users::where('user_id', '!=', 1)
      ->where('status', 1)
      ->orderBy('post', 'asc')
      ->orderBy('username', 'asc')
      ->get();

    $teamType = WorkTeamType::get()->all();

    return view('admin.seo_team.create_team', ['users' => $users, 'teamType' => $teamType]);
  }

  /**
   * Create team
   */
  public function createTeam(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'team_name' => 'required|unique:work_team_info|max:150',
        'leader_id' => "required",
        'members_id' => "required",
        'team_type' => "required|numeric|min:1|max:255"
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $teamName = ucwords($request->input('team_name'));
    $leaderId = $request->input('leader_id');
    $membersId = $request->input('members_id');
    $teamType = $request->input('team_type');


    $inId = WorkTeamInfo::insertGetId([
      'team_type' => $teamType,
      'team_name' => $teamName,
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s')
    ]);

    //insert member data
    if ($inId > 0) {

      $inData = [];

      foreach ($leaderId as $id) {
        $inData[] = [
          'work_team_id' => $inId,
          'user_id' => $id,
          'member_type' => 'team_leader'
        ];
      }


      foreach ($membersId as $id) {
        $inData[] = [
          'work_team_id' => $inId,
          'user_id' => $id,
          'member_type' => 'team_member'
        ];
      }

      $insert = WorkTeamMembers::insert($inData);

      if ($insert) {
        $return['code'] = 200;
        $return['msg'] = 'Team created succesfully.';
      } else {
        $return['code'] = 101;
        $return['msg'] = 'Team members record insert failed.';
      }
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Team info record insert failed!';
    }

    return response()->json($return);
  }



  /**
   * View balde for Edit Team
   */
  public function viewEditTeam($team_id)
  {

    $teamInfo = WorkTeamInfo::where('wt_id', $team_id)->first();

    if (empty($teamInfo)) {
      return abort(404);
    }


    $users = Users::where('user_id', '!=', 1)
      ->where('status', 1)
      ->orderBy('post', 'asc')
      ->orderBy('username', 'asc')
      ->get();

    $teamType = WorkTeamType::get()->all();

    //fetching team members
    $memberInfo = $teamInfo->workTeamMembers;

    $teamLeaderList = [];
    $teamMemberList = [];

    foreach ($memberInfo as $row) {
      if ($row->member_type === 'team_leader') {
        $teamLeaderList[] = $row->user_id;
      } else {
        $teamMemberList[] = $row->user_id;
      }
    }


    $usersList = [];
    //removing users from list
    foreach ($users as $row) {
      if (in_array($row->user_id, array_merge($teamLeaderList, $teamMemberList))) {
        continue;
      }

      $usersList[] = $row;
    }

    return view('admin.seo_team.edit_team', ['teamType' => $teamType, 'users' => $usersList, 'teamInfo' => $teamInfo, 'team_id' => $team_id]);
  }


  /**
   * Update team
   */
  public function updateTeam(Request $request)
  {

    $teamId = ucwords($request->input('team_id'));

    $validator = Validator::make(
      $request->all(),
      [
        'team_id' => 'required|min:1|max:999999999',
        'team_name' => "required|unique:work_team_info,team_name,{$teamId},wt_id|max:150",
        'team_type' => "required|numeric|min:1|max:255"
        // 'leader_id' => "required",
        // 'members_id' => "required"
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $teamName = ucwords($request->input('team_name'));
    $leaderId = $request->input('leader_id');
    $membersId = $request->input('members_id');
    $teamType = $request->input('team_type');

    $checkTeam = WorkTeamInfo::find($teamId);


    if (empty($checkTeam)) {
      $return['code'] = 101;
      $return['msg'] = 'Invalid Team ID.';

      return response()->json($return);
    }


    $checkTeam->team_name = $teamName;
    $checkTeam->team_type = $teamType;


    $isUpdateTeamInfo = false;

    if ($checkTeam->isDirty()) {
      $checkTeam->save();

      $isUpdateTeamInfo = true;
    }

    //insert member data
    if ($teamId > 0) {

      $inData = [];

      if (!empty($leaderId)) {
        foreach ($leaderId as $id) {
          $inData[] = [
            'work_team_id' => $teamId,
            'user_id' => $id,
            'member_type' => 'team_leader'
          ];
        }
      }

      if (!empty($membersId)) {
        foreach ($membersId as $id) {
          $inData[] = [
            'work_team_id' => $teamId,
            'user_id' => $id,
            'member_type' => 'team_member'
          ];
        }
      }

      if (!empty($inData)) {
        $insert = WorkTeamMembers::insert($inData);
      } else {
        $insert = false;
      }

      if ($insert || $isUpdateTeamInfo) {
        $return['code'] = 200;
        $return['msg'] = 'Team updated succesfully.';
      } else {
        $return['code'] = 101;
        $return['msg'] = 'Team members record not inserted.';
      }
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Team info record insert failed!';
    }

    return response()->json($return);
  }




  /**
   * Member list
   */
  public function listMemberTeam($team_id)
  {
    $list = WorkTeamMembers::with(['users.designation'])->where('work_team_id', $team_id)->orderBy('member_type', 'asc')->get();

    if (empty($list)) {
      $return['code'] = 101;
      $return['msg'] = 'No data';
    } else {
      $return['code'] = 200;
      $return['msg'] = 'Team data found';
      $return['data'] = $list;
    }

    return response()->json($return);
  }



  /**
   * Team List
   */
  public function listTeam()
  {
    $list = WorkTeamInfo::with(['workTeamMembers.username'])
      ->orderBy('team_name', 'asc')->get();



    $newList = [];

    $workTeamType = WorkTeamType::get();

    foreach ($list as $row) {
      $row->team_type = $workTeamType->value($row->team_type);
      $newList[] = $row;
    }


    if (empty($list)) {
      $return['code'] = 100;
      $return['msg'] = 'No data';
    } else {
      $return['code'] = 200;
      $return['msg'] = 'Team data found';
      $return['data'] = $newList;
    }

    return response()->json($return);
  }







  /**
   * Delete User Website Relation
   */
  public function deleteTeam(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'team_id' => "required|numeric|max:9999999999",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors()->get('team_id');

      return response()->json($return);
    }

    $teamId = $request->input('team_id');

    //delete data from main table main 
    $delete = WorkTeamInfo::where('wt_id', $teamId)->delete();

    if ($delete === 1) {

      //delete data from sub table
      WorkTeamMembers::where('work_team_id', $teamId)->delete();

      $return['code'] = 200;
      $return['msg'] = 'Team deleted.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Team not deleted or not found.';
    }

    return response()->json($return);
  }


  /**
   * Delete member
   */
  public function deleteMember(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'member_id' => "required|numeric|max:9999999999",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors()->get('member_id');

      return response()->json($return);
    }

    $memberId = $request->input('member_id');

    //delete data from main table main 
    $delete = WorkTeamMembers::where('wtm_id', $memberId)->delete();

    if ($delete === 1) {

      $return['code'] = 200;
      $return['msg'] = 'Team deleted.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Team not deleted or not found.';
    }

    return response()->json($return);
  }
}
