<?php

namespace App\Http\Controllers\Admin\PagesAccess;

use App\Classes\AccessManager\PortalUrls;
use App\Http\Controllers\Controller;
use App\Models\AdminPageAccess;
use App\Models\Users;
use Illuminate\Http\Request;
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

    $urls = new PortalUrls();
    $adminUrls = $urls->getAdminUrls();

    return view('admin.pages_access.assign_access', ['users' => $users, 'adminUrls' => $adminUrls]);
  }



  /**
   * Insert data for grand access
   */
  public function insertGrantAccess(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'user_id' => "required|numeric|min:1|max:9999999999",
        'urls' => "required|array",
      ]
    );


    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    $userId = $request->input('user_id');
    $urls = $request->input('urls');

    $insertData = [];

    foreach ($urls as $url) {
      $insertData[] = [
        'user_id' => $userId,
        'page_url' => $url,
        'created_at' => date('Y-m-d')
      ];
    }


    $insert = AdminPageAccess::insert($insertData);


    if ($insert) {
      $return['code'] = 200;
      $return['msg'] = 'Access Granted succesfully.';
    } else {
      $return['code'] = 100;
      $return['msg'] = 'Order record insertion failed.';
    }

    return response()->json($return);
  }
}
