<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\EmpDesignation;
use App\Models\UserAddress;
use App\Models\UserBankInfo;
use App\Models\Users;
use App\Models\UserSalary;
use App\Models\UsersBankInfo;
use App\Models\UsersDocument;
use App\Models\UsersInfo;
use App\Models\UserVaccinateDoc;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserInfoCtrl extends Controller
{
  /**
   * 
   */
  // public function viewEditUserInfo($user_id)
  // {
  //   //finding and getting user info
  //   $user = Users::find($user_id);

  //   if (empty($user)) {
  //     return abort(404);
  //   }

  //   $data['user'] = $user;

  //   return view('admin.users.edit_user_info', $data);
  // }

  public function viewEditUserInfo($user_id)
  {
    //finding and getting user info
    $user = Users::find($user_id);
    $userInfo = UserBankInfo::where('user_id', $user_id)->first();
    $userDocs = UsersDocument::where('user_id', $user_id)->get();
    $bankinfo = UsersBankInfo::where('user_id', $user_id)->first();
    $userAddress = UserAddress::where('user_id', $user_id)->get();
    $userVaccineOne = UserVaccinateDoc::where('user_id', $user_id)->where('type', '1')->get();
    $userVaccineTwo = UserVaccinateDoc::where('user_id', $user_id)->where('type', '2')->get();

    if (empty($user)) {
      return abort(404);
    }

    $data['user'] = $user;
    $data['userDocs'] = $userDocs;
    $data['bankinfo'] = $bankinfo;
    $data['userInfo'] = $userInfo;
    $data['userId'] = $user_id;
    $data['userAddress'] = $userAddress;
    $data['userVaccineOne'] = $userVaccineOne;
    $data['userVaccineTwo'] = $userVaccineTwo;

    return view('admin.users.edit_user_info', $data);
  }



  /**
   * 
   */
  public function insertUserInfo(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'user_id' => "required|numeric|max:9999999999",
        'user_email' => "required|email|max:150",
        'emp_code' => "required|unique:users_info|max:20",
        'first_name' => "required|min:2|max:100",
        'middle_name' => "nullable|min:2|max:100",
        'work_phone' => 'required|min:10|max:20',
        'personal_phone' => 'nullable|min:10|max:20',
        'last_name' => "required|min:2|max:100",
        'gender' => "required|min:1|max:1",
        'doj' => "required|date",
        'dor' => "nullable|date",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    $user_id = $request->input('user_id');

    $user = Users::find($user_id);

    if (empty($user)) {
      $return['code'] = 101;
      $return['msg'] = 'No User Found!';

      return response()->json($return);
    }

    $userInfo = UsersInfo::where('user_id', $user_id)->first();

    if (empty($userInfo)) {
      $userInfo = new UsersInfo();

      $userInfo->user_id = ($request->input('user_id'));
    }



    $userInfo->emp_code = strtoupper($request->input('emp_code'));
    $userInfo->first_name = ucwords($request->input('first_name'));
    $userInfo->last_name = ucwords($request->input('last_name'));
    $userInfo->middle_name = ucwords($request->input('middle_name'));
    $userInfo->personal_email = strtolower($request->input('user_email'));
    $userInfo->work_phone = strtolower($request->input('work_phone'));
    $userInfo->personal_phone = strtolower($request->input('personal_phone'));
    $userInfo->gender = $request->input('gender');
    $userInfo->date_of_joining = $request->input('doj');
    $userInfo->date_of_relieving = $request->input('dor');


    if ($userInfo->isClean()) {
      $return['code'] = 101;
      $return['msg'] = 'No changes have been made!';

      return response()->json($return);
    }



    if ($userInfo->save()) {

      $return['code'] = 200;
      $return['msg'] = 'Employee has been updated.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }




  /**
   * 
   */
  public function updateUserInfo(Request $request)
  {

    $user_info_id = $request->input('user_info_id');

    $validator = Validator::make(
      $request->all(),
      [
        'user_id' => "required|numeric|max:9999999999",
        'user_email' => "required|email|max:150",
        'emp_code' => "required|unique:users_info,emp_code,{$user_info_id},id|max:20",
        'first_name' => "required|min:2|max:100",
        'middle_name' => "nullable|min:2|max:100",
        'work_phone' => 'required|min:10|max:20',
        'personal_phone' => 'nullable|min:10|max:20',
        'last_name' => "required|min:2|max:100",
        'gender' => "required|min:1|max:1",
        'doj' => "required|date",
        'dor' => "nullable|date",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    $user_id = $request->input('user_id');

    $user = Users::find($user_id);

    if (empty($user)) {
      $return['code'] = 101;
      $return['msg'] = 'No User Found!';

      return response()->json($return);
    }

    $userInfo = UsersInfo::where('user_id', $user_id)->first();

    if (empty($userInfo)) {
      $userInfo = new UsersInfo();

      $userInfo->user_id = ($request->input('user_id'));
    }



    $userInfo->emp_code = strtoupper($request->input('emp_code'));
    $userInfo->first_name = ucwords($request->input('first_name'));
    $userInfo->last_name = ucwords($request->input('last_name'));
    $userInfo->middle_name = ucwords($request->input('middle_name'));
    $userInfo->personal_email = strtolower($request->input('user_email'));
    $userInfo->work_phone = strtolower($request->input('work_phone'));
    $userInfo->personal_phone = strtolower($request->input('personal_phone'));
    $userInfo->gender = $request->input('gender');
    $userInfo->date_of_joining = $request->input('doj');
    $userInfo->date_of_relieving = $request->input('dor');


    if ($userInfo->isClean()) {
      $return['code'] = 101;
      $return['msg'] = 'No changes have been made!';

      return response()->json($return);
    }



    if ($userInfo->save()) {

      $return['code'] = 200;
      $return['msg'] = 'Employee has been updated.';
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }


  public function getDetailedInfo()
  {

    $userInfoDetailed = UsersInfo::with(['users'])->get();
    $emp_dur_interval = '';
    foreach ($userInfoDetailed as $row) {

      // dd($row->users->designation);

      $desig = EmpDesignation::select('des_name')->where('des_id', $row->users->designation)->first();
    // dd($desig->des_name);

      $row->designation = $desig->des_name;

      $prob = $row->date_of_joining;
      /**
       * =================
       * Employee Duration
       * =================
       */
      // $emp_dur = date_create($prob);
      // $emp_dur_today = date_create(date('Y-m-d'));
      // $empDiff = date_diff($emp_dur_today, $emp_dur);
      // $emp_duration = $empDiff->format("%m month");

      $emp_dur = new DateTime($prob);
      $emp_dur_today = new DateTime(date('Y-m-d'));
      $emp_dur_interval = $emp_dur->diff($emp_dur_today);


      if(!empty($emp_dur_interval->y)){
        $str_emp_dur = "$emp_dur_interval->y years $emp_dur_interval->m month  $emp_dur_interval->d days";
      }else if(empty($emp_dur_interval->y) && !empty($emp_dur_interval->m) && !empty($emp_dur_interval->d)){
        $str_emp_dur = "$emp_dur_interval->m month  $emp_dur_interval->d days";
      }else if(empty($emp_dur_interval->y)  && empty($emp_dur_interval->m) && !empty($emp_dur_interval->d)){
        $str_emp_dur = "$emp_dur_interval->d days";
      }

      // $str_emp_dur = "$emp_dur_interval->y years $emp_dur_interval->m month  $emp_dur_interval->d days";


      $row->emp_duration = $str_emp_dur;

      $date = date_create($prob);
      date_modify($date, "+6 Month");
      $date_new =  date_format($date, "Y-m-d");

      $row->prob_date = $date_new;


      $date1 = date_create($date_new);
      $date2 = date_create(date('Y-m-d'));
      $diff = date_diff($date1, $date2);
      $prob_mod_days = $diff->format("%R%a days");
      $prob_mod_month = $diff->format("%R%m month");

      $date_prob_one = new DateTime($date_new);
      $date_prob_two = new DateTime(date('Y-m-d'));
      $interval_prob = $date_prob_one->diff($date_prob_two);
      

      // if (strpos($prob_mod_days, '-')) {
      //     $prob_remain = $diff->format("%a days");
      // }else{
      //   $prob_remain = ' ';
      // }

      $search = '-';
      if (preg_match("/{$search}/i", $prob_mod_days)) {
        $prob_remain = $diff->format("%a days");
        // $str_prob = "$interval_prob->y years $interval_prob->m month  $interval_prob->d days";

        
        if(!empty($interval_prob->y)){
          $str_prob = "$interval_prob->y years $interval_prob->m month  $interval_prob->d days";
        }else if(empty($interval_prob->y) && !empty($interval_prob->m) && !empty($interval_prob->d)){
          $str_prob = "$interval_prob->m month  $interval_prob->d days";
        }else if(empty($interval_prob->y)  && empty($interval_prob->m) && !empty($interval_prob->d)){
          $str_prob = "$interval_prob->d days";
        }


      } else {
        $prob_remain = ' ';
        $str_prob = ' ';
      }

      if (preg_match("/{$search}/i", $prob_mod_month)) {
        // $prob_remain_month = $diff->format("%m month");
        // $str_prob = "$interval_prob->y years $interval_prob->m month  $interval_prob->d days";
          if(!empty($interval_prob->y)){
            $str_prob = "$interval_prob->y years $interval_prob->m month  $interval_prob->d days";
          }else if(empty($interval_prob->y) && !empty($interval_prob->m) && !empty($interval_prob->d)){
            $str_prob = "$interval_prob->m month  $interval_prob->d days";
          }else if(empty($interval_prob->y)  && empty($interval_prob->m) && !empty($interval_prob->d)){
            $str_prob = "$interval_prob->d days";
          }
      } else {
        $prob_remain_month = ' ';
        $str_prob = ' ';
      }



      // if (strpos($prob_mod_month, '-')) {
      //   $prob_remain_month = $diff->format("%R%m month");
      // } else {
      //   $prob_remain_month = ' ';
      // }

      $row->prob_day_remain = $prob_remain;
      // $row->prob_month_remain = $prob_remain_month;
      $row->prob_month_days_remain = $str_prob;
 
      $salary = UserSalary::select('salary', 'last_date')->where('user_id', $row->user_id)->orderBy('id', 'DESC')->first();
      if (!empty($salary)) {
        $row->salary = $salary->salary;
        $row->salary_last_date = $salary->last_date;

        if (!empty($salary->last_date)) {
          $last_date = date_create($salary->last_date);
          date_modify($last_date, "+1 Year");
          $last_date_increment =  date_format($last_date, "Y-m-d");

          // $date_last_date_increment = date_create($last_date_increment);
          // // dd($date_last_date_increment);
          // date_modify($date_last_date_increment, "+1 Year");

          // $date_next_inc =  date_format($date_last_date_increment, "Y-m-d");

          $date_today = date_create(date('Y-m-d'));
          $date_next_inc_create = date_create($last_date_increment);
          $diff_salary = date_diff($date_today, $date_next_inc_create);
          $salary_next_inc_days = $diff_salary->format("%a days");
          // $salary_next_inc_month = $diff_salary->format("%R%m month");

          $date_sal_one = new DateTime($last_date_increment);
          $date_sal_two = new DateTime(date('Y-m-d'));
          $interval = $date_sal_one->diff($date_sal_two);

          $str_sal = "$interval->y years $interval->m month  $interval->d days";

          if(!empty($interval->y)){
            $str_sal = "$interval->y years $interval->m month  $interval->d days";
          }else if(empty($interval->y) && !empty($interval->m) && !empty($interval->d)){
            $str_sal = "$interval->m month  $interval->d days";
          }else if(empty($interval->y)  && empty($interval->m) && !empty($interval->d)){
            $str_sal = "$interval->d days";
          }

          $row->salary_increment = $last_date_increment;
          // $row->salary_next_increment = $date_next_inc;
          $row->salary_next_inc_days = $salary_next_inc_days; 
          // $row->salary_mod_month = $salary_next_inc_month;
          $row->salary_next_inc_month_days = $str_sal;
        }
      } else {
        $row->salary = '';
        $row->salary_last_date = '';
      }

      $document = UsersDocument::select('id')->where('user_id', $row->user_id)->count();

      if ($document > 0) {
        $row->document = 1;
      } else {
        $row->document = 0;
      }


      $vaccineOne = UserVaccinateDoc::select('id')->where('user_id', $row->user_id)->where('type', 1)->count();

      if ($vaccineOne > 0) {
        $row->vac_dose_one = 1;
      } else {
        $row->vac_dose_one = 0;
      }

      $vaccineTwo = UserVaccinateDoc::select('id')->where('user_id', $row->user_id)->where('type', 2)->count();

      if ($vaccineTwo > 0) {
        $row->vac_dose_two = 1;
      } else {
        $row->vac_dose_two = 0;
      }
    }

    // dd($userInfo);
    if ($userInfoDetailed) {

      $return['code'] = 200;
      $return['msg'] = 'Data Found.';
      $return['data'] = $userInfoDetailed;
    } else {
      $return['code'] = 101;
      $return['msg'] = 'Error: Please contact administrator.';
    }

    return response()->json($return);
  }

  public function getDetailedView()
  {
    return view('admin.users.detailed_user_info');
  }
}
