<?php

namespace App\Http\Controllers\EmployeeManagement;

use App\Http\Controllers\Controller;
use App\Mail\UserAdded as MailUserAdded;
use App\Models\Users;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;



class UserCtrl extends Controller
{


  /**
   * Get Users List
   */
  public function usersList()
  {
    $usersList = Users::with(['department', 'post', 'designation'])
      ->orderBy('post', 'asc')
      ->orderBy('username', 'asc')
      ->get();

    $usersList->makeHidden(['password', 'attendance_token']);

    $return['code'] = 200;
    $return['data'] = $usersList;

    return response()->json($return);
  }


  /**
   * Get User List by Post
   */
  // public function usersListByPost()
  // {
  //   $usersList = Users::with(['department', 'post', 'designation'])->get();

  //   $usersList->makeHidden(['password', 'attendance_token']);

  //   $return['code'] = 200;
  //   $return['data'] = $usersList;

  //   return response()->json($return);
  // }



  /**
   * Add new user
   * POST method
   */
  public function addNewUser(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'user_email' => "required|email|unique:users,email|max:150",
        'username' => "required|alpha_dash|unique:users,username|max:150",
        'password' => "required|max:50",
        'department' => "required|numeric",
        'post' => "required|numeric",
        'designation' => "required|numeric",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();
      return response()->json($return);
    }

    $users = new Users();
    $users->username = $request->input('username');
    $users->email = $request->input('user_email');
    $users->password = Hash::make($request->input('password'));
    $users->department = $request->input('department');
    $users->post = $request->input('post');
    $users->designation = $request->input('designation');
    $users->status = 1;


    if ($users->save()) {


      $details = [
        'subject' => 'Registration Successful at Work Report Portal - Logelite',
        'username' => $users->username,
        'password' => $request->input('password')
      ];

      try {
        Mail::to($users->email)->send(new MailUserAdded($details));

        $return['code'] = 200;
        $return['msg'] = 'New employee has been added.';
      } catch (Exception $e) {

        $return['code'] = 200;
        $return['msg'] = 'New employee has been added. But mail not send to the user.';
      }
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }



  public function updateUser(Request $request)
  {

    $user_id = $request->input('user_id');

    $validator = Validator::make(
      $request->all(),
      [
        'user_id' => "required|numeric|max:9999999999",
        // 'user_email' => [
        //   Rule::unique('driver_details')->ignore($id),
        // ],
        'user_email' => "required|email|unique:users,email,{$user_id},user_id|max:150",
        'username' => "required|alpha_dash|unique:users,username,{$user_id},user_id|max:150",
        'password' => "nullable|max:50",
        'department' => "required|numeric",
        'post' => "required|numeric",
        'designation' => "required|numeric",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    $user = Users::find($user_id);

    if (empty($user)) {
      $return['code'] = 101;
      $return['msg'] = 'No User Found!';

      return response()->json($return);
    }

    $user->username = $request->input('username');
    $user->email = $request->input('user_email');

    if (!empty($request->input('password'))) {
      $user->password = Hash::make($request->input('password'));
    }

    $user->department = $request->input('department');
    $user->post = $request->input('post');
    $user->designation = $request->input('designation');
    // $user->status = 1;

    if ($user->isClean()) {
      $return['code'] = 101;
      $return['msg'] = 'No changes have been made!';

      return response()->json($return);
    }


    if ($user->save()) {

      if (!empty($request->input('password'))) {
        $details = [
          'subject' => 'User Update Successful at Work Report Portal - Logelite',
          'username' => $user->username,
          'password' => $request->input('password')
        ];

        try {
          Mail::to($user->email)->send(new MailUserAdded($details));

          $return['code'] = 200;
          $return['msg'] = 'Employee has been updated.';
        } catch (Exception $e) {

          $return['code'] = 200;
          $return['msg'] = 'Employee has been updated. But mail not send to the user.';
        }
      }
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }


  /**
   * Update User Status
   */
  public function updateUserStatus(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'id' => "required|numeric"
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = "Invalid User ID!";

      return response()->json($return);
    }

    $id = $request->input('id');




    $user = Users::find($id);

    if (empty($user)) {
      $return['code'] = 101;
      $return['msg'] = 'No User Found!';

      return response()->json($return);
    }


    if ($user->user_id === 1) {
      $return['code'] = 101;
      $return['msg'] = "Can't Deactivate this user!";

      return response()->json($return);
    }






    //toggle the user status
    if ($user->status === 1) {
      $user->status = 0;
      $msg = "User &nbsp; <strong>DEACTIVATED</strong> &nbsp; successfully.";
      $btn['text'] = "Deactivated";
      $btn['remClass'] = "btn-success";
      $btn['addClass'] = "btn-secondary";
    } else if ($user->status === 0) {
      $user->status = 1;
      $msg = "User &nbsp; <strong>ACTIVATED</strong> &nbsp; successfully.";
      $btn['text'] = "Activated";
      $btn['addClass'] = "btn-success";
      $btn['remClass'] = "btn-secondary";
    }


    if ($user->save()) {

      $return['code'] = 200;
      $return['msg'] = $msg;
      $return['btn'] = $btn;
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }
}
