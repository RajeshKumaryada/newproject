<?php

namespace App\Http\Controllers\WorkPortal\SeoExecutive;

use App\Classes\TrackSession;
use App\Classes\Variables\WorkTeamType;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\WorkTeamInfo;
use App\Models\WorkTeamMembers;

class SeoTeamCtrl extends Controller
{
  /**
   * 
   */
  public function viewSeoTeam()
  {

    $teamInfo = WorkTeamInfo::orderBy('team_name', 'asc')
      ->get();


    //selecting content writers
    $contentWriters = Users::where('post', 1)
      ->where('status', 1)
      ->orderBy('username', 'asc')
      ->get();


    $workTeamType = WorkTeamType::get();

    $loginUserMemberType = WorkTeamMembers::where('user_id', TrackSession::get()->userId())->first();


    return view('work_portal.seo_executive.team_info', ['teamInfo' => $teamInfo, 'contentWriters' => $contentWriters, 'workTeamType' => $workTeamType, 'loginUserMemberType' => $loginUserMemberType]);
  }
}
