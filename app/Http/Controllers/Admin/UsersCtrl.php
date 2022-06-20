<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Users;

class UsersCtrl extends Controller
{

  public function viewAddUser()
  {
    return view('admin.add_new_user');
  }

  public function viewManageUser()
  {
    return view('admin.manage_user');
  }


  public function viewEditUser($user_id)
  {

    //finding and getting user info
    $user = Users::find($user_id);

    if (empty($user)) {
      return abort(404);
    }

    $data['user'] = $user;

    return view('admin.edit_user', $data);
  }
}
