<?php

namespace App\Http\Controllers\Admin\SiteManagement;

use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\WebsiteInfo;
use App\Models\WebsiteUsersRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiteUserRelationCtrl extends Controller
{

  /**
   * 
   */
  public function viewForSiteUserRelation()
  {

    $users = Users::where('user_id', '!=', 1)->where('post', 4)->orderBy('username', 'asc')->get();

    $websites = WebsiteInfo::orderBy('site_name', 'asc')->get();

    return view('admin.website_management.site_user_relation', ['users' => $users, 'websites' => $websites]);
  }



  /**
   * View for edit website and user relationship
   */
  public function viewForEditSiteUserRelation($userId)
  {



    //getting user info
    $user = Users::find($userId);

    if (empty($user)) {
      return abort(404);
    }

    //getting website list for selected uses
    $selected = WebsiteUsersRelation::select('site_id')->where('user_id', $userId)->get();

    if (empty($selected)) {
      return abort(404);
    }


    //getting users list
    // $users = Users::where('user_id', '!=', 1)->where('post', 4)->orderBy('username', 'asc')->get();

    //getting website list
    $websites = WebsiteInfo::orderBy('site_name', 'asc')->get();




    $siteIds = [];

    foreach ($selected as $row) {
      $siteIds[] = $row->site_id;
    }


    return view('admin.website_management.site_user_relation_edit', ['user' => $user, 'websites' => $websites, 'siteIds' => $siteIds, 'userId' => $userId]);
  }



  /**
   * POST
   */
  public function assignSiteUserRelation(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'user_id' => "required|numeric|max:9999999999",
        'site_list' => "required"
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $user_id = $request->input('user_id');

    $site_list = $request->input('site_list');

    // print_r($request->all());

    $inData = [];

    foreach ($site_list as $site_id) {
      $inData[] = [
        'user_id' => $user_id,
        'site_id' => $site_id
      ];
    }

    $insert = WebsiteUsersRelation::insert($inData);

    if ($insert) {
      $return['code'] = 200;
      $return['msg'] = 'Site assigned succesfully.';
    } else {
      $return['code'] = 100;
      $return['msg'] = 'Site assigned Failed.';
    }

    return response()->json($return);
  }



  /**
   * Fetch Site User Relation
   */
  public function fetchSiteUserRelation()
  {
    // $siteInfo = WebsiteInfo::with(['websiteUsersRelation.users'])
    //   ->select('website_info.*')
    //   // ->leftJoin('website_users_relation', 'website_info.id', 'website_users_relation.site_id')
    //   ->orderBy('site_name', 'asc')
    //   ->get();

    // $siteInfo = Users::with(['siteUsersRelation.siteInfo'])
    //   ->select('users.*')
    //   ->leftJoin('website_users_relation', 'users.user_id', 'website_users_relation.user_id')
    //   ->get();

    // $siteInfo = Users::with(['siteUsersRelation.siteInfo'])
    //   ->select('users.*')
    //   // ->leftJoin('website_users_relation', 'users.user_id', 'website_users_relation.user_id')
    //   ->where('users.user_id', '!=', 1)
    //   ->get();


    $siteInfo = WebsiteUsersRelation::with(['siteInfo', 'users'])
      ->orderBy('id', 'asc')
      ->get();

    $return['code'] = 200;
    $return['msg'] = 'Data found!';
    $return['data'] = $siteInfo;

    return response()->json($return);
  }


  /**
   * Fetch Single User Site Relation
   */
  public function fetchSingleUserSiteRelation($userId)
  {
    $siteInfo = WebsiteUsersRelation::with(['siteInfo', 'users'])
      ->where('user_id', $userId)
      ->orderBy('id', 'asc')
      ->get();

    $return['code'] = 200;
    $return['msg'] = 'Data found!';
    $return['data'] = $siteInfo;

    return response()->json($return);
  }


  /**
   * Delete User Website Relation
   */
  public function deleteSiteUserRelation(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'site_id' => "required|numeric|max:9999999999",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $siteId = $request->input('site_id');

    $delete = WebsiteUsersRelation::where('id', $siteId)->delete();

    // dd($delete);

    if ($delete === 1) {
      $return['code'] = 200;
      $return['msg'] = 'Relation deleted.';
    } else {
      $return['code'] = 100;
      $return['msg'] = 'Relation not deleted or not found.';
    }

    return response()->json($return);
  }
}
