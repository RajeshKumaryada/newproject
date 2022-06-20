<?php

namespace App\Http\Controllers\Admin\PagesAccess;

use App\Classes\AccessManager\PortalUrls;
use App\Http\Controllers\Controller;
use App\Models\AdminPageAccess;
use App\Models\AdminPageAccessUsers;
use App\Models\Users;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PagesAccessCtrl extends Controller
{


  /**
   * Used for show view and forms
   */
  public function viewForGrantAccess()
  {
    $users = Users::where('username', '!=', 'admin')
      ->where('status', 1)
      ->orderBy('post', 'ASC')
      ->orderBy('username', 'ASC')
      ->get();

    // $urls = new PortalUrls();
    // $adminUrls = $urls->getAdminUrls();

    return view('admin.pages_access.assign_access', ['users' => $users]);
  }



  /**
   * Insert data for grand access
   */
  public function insertGrantAccess(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'page_name' => "required|min:1|max:500",
        'user_id' => "required|array",
        'url' => "required",
      ]
    );


    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    $userId = $request->input('user_id');
    $url = $request->input('url');
    $pageName = $request->input('page_name');

    $pageAccess = AdminPageAccess::where('page_url', $url)->first();

    if (empty($pageAccess)) {
      $pageAccess = new AdminPageAccess();

      $pageAccess->page_name = $pageName;
      $pageAccess->page_url = $url;
      $pageAccess->created_at = date('Y-m-d H:i:s');

      $pageAccess->save();
    } else {
      $pageAccess->page_name = $pageName;
      $pageAccess->updated_at = date('Y-m-d H:i:s');

      $pageAccess->save();
    }


    if (!empty($pageAccess)) {

      $insertData = [];

      foreach ($userId as $user) {
        $insertData[] = [
          'page_access_id' => $pageAccess->id,
          'user_id' => $user,
        ];
      }

      try {
        AdminPageAccessUsers::upsert($insertData, ['page_access_id', 'user_id']);

        $return['code'] = 200;
        $return['msg'] = 'Access Granted succesfully.';
      } catch (Exception $e) {
        $return['code'] = 101;
        $return['msg'] = $e->getMessage();
      }
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Order record insertion failed.';
    }

    return response()->json($return);
  }




  /**
   * Access List
   */
  public function accessList()
  {
    $list = AdminPageAccess::with(['assigndUsers.userName'])
      ->orderBy('created_at', 'asc')->get();


    if (empty($list)) {
      $return['code'] = 100;
      $return['msg'] = 'No data';
    } else {
      $return['code'] = 200;
      $return['msg'] = 'Team data found';
      $return['data'] = $list;
    }

    return response()->json($return);
  }



  /**
   * Delete Access Rules
   */
  public function deleteAccess(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'access_id' => "required|numeric|max:9999999999",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors()->get('access_id');

      return response()->json($return);
    }

    $id = $request->input('access_id');

    //delete data from main table main 
    $delete = AdminPageAccess::where('id', $id)->delete();

    if ($delete === 1) {

      //delete data from sub table
      AdminPageAccessUsers::where('page_access_id', $id)->delete();

      $return['code'] = 200;
      $return['msg'] = 'Access deleted.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Access not deleted or not found.';
    }

    return response()->json($return);
  }



  /**
   * Delete Access Users
   */
  public function deleteAccessUser(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'access_user_id' => "required|numeric|max:9999999999",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors()->get('access_user_id');

      return response()->json($return);
    }

    $id = $request->input('access_user_id');

    //delete data from main table main 
    $delete = AdminPageAccessUsers::where('id', $id)->delete();

    if ($delete === 1) {

      $return['code'] = 200;
      $return['msg'] = 'User deleted.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'User not deleted or not found.';
    }

    return response()->json($return);
  }
}
