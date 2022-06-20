<?php

namespace App\Http\Controllers\Login;

use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\AdminPageAccessUsers;
use Exception;

class LoginAdminAccess extends Controller
{

  /**
   * Login to Leave Portal
   */
  public function getAdminPages()
  {

    if (TrackSession::has())
      $trackSession = TrackSession::get();
    else
      return abort(404);


    $pageList = AdminPageAccessUsers::with(['pageUrl'])->where('user_id', $trackSession->userId())->get();


    return view('work_portal.admin_access_pages', ['pageList' => $pageList]);
  }



  public function loginToAdminAccess($page)
  {
    if (TrackSession::has())
      $trackSession = TrackSession::get();
    else
      return abort(404);

    try {
      $pageId = decrypt($page);
    } catch (Exception $e) {
      return abort(404);
    }

    $pageList = AdminPageAccessUsers::with(['pageUrl'])
      ->where('user_id', $trackSession->userId())
      ->find($pageId);

    if (!empty($pageList)) {

      $trackSession->userAsAdmin = '1';

      request()->session()->put(TrackSession::ADMIN_SESSION, serialize($trackSession));

      return redirect($pageList->pageUrl->page_url);
    }

    return abort(404);
  }







  /**
   * Generate Random String
   */
  private function generateRandomString($length)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
}
