<?php

namespace App\Http\Controllers\Admin\UserAlarm;

use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\UsersAlam;
use App\Models\UsersAlarmRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserAlarmCtrl extends Controller
{
    /**
     * Create Alam
     */
    public function create()
    {

        $users = Users::where('username', '<>', 'admin')
            ->orderBy('post', 'ASC')
            ->orderBy('username', 'ASC')
            ->get();

        $alarm = UsersAlam::get()->all();


        $array =[] ;
        foreach ($alarm as $idr => $valNew) {
            $array[] = $valNew->user_id;
        }

        $usersList = [];
        //removing users from list
        foreach ($users as $row) {
            if (in_array($row->user_id, array_merge($array))) {
                continue;
            }

            $usersList[] = $row;
            // dd($users);
        }


        return view('admin.manage_alarm.alarm_manage', ['users' => $usersList]);
    }

    /**
     * Add New Alarm
     */
    public function addAlarmNew(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_list' => "required",
                'time_in_hr' => "required",
                'time_in_min' => "required"
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();
            return response()->json($return);
        }

        $user_list = $request->user_list;
        $hr = $request->time_in_hr;
        $min = $request->time_in_min;

        // dd($user_list);
        $data = [];
        foreach ($user_list as $idx => $val) {

            $data = [
                'user_id'    => $val,
                'status'     => "1",
                'time_in_hr'       => $hr,
                'time_in_min'       => $min,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            //   $usersAdd = UsersAlam::insert($data);

            //   $usersAdd =  UsersAlam::create($data, [$val]);

            $usersAdd = UsersAlam::upsert($data, [$val]);
        }

        if ($usersAdd) {


            $return['code'] = 200;
            $return['msg'] = "Add Alarm Successfully";
            $return['data'] = $usersAdd;
        } else {
            $return['code'] = 101;
            $return['msg'] = "Add Alarm Failed";
        }

        return response()->json($return);
    }


    /**
     * Fetch Alamars
     */
    public function fetchAllAlarm()
    {
        $alamsAll = UsersAlam::select('id', 'user_id', 'status', 'time_in_hr', 'time_in_min', 'created_at')->orderBy('id', 'DESC')->get();

        foreach ($alamsAll as $row) {

            $user_id = explode(',', $row->user_id);

            $users = Users::select('username')
                ->whereIn('user_id', $user_id)
                ->get();

            $row->usernames = $users;
        }

        $return['code'] = 200;
        $return['msg'] = "Data Found";
        $return['data'] = $alamsAll;

        return response()->json($return);
    }

    /**
     * Change status Active to Not active
     */
    public function addStatusActive(Request $request)
    {
        $id =  $request->id;
        $status = $request->status;
        // dd($id);

        $EmpStatus = UsersAlam::find($id);

        $EmpStatus->status = 2;

        if ($EmpStatus->save()) {

            $return['code'] = 200;
            $return['msg'] = "Deactive Successfully";
            $return['data'] = $EmpStatus;
        } else {
            $return['code'] = 101;
            $return['msg'] = "Deactivation Failed";
        }
        return response()->json($return);
    }

    /**
     * Change status Active to Not active
     */
    public function addStatusNotActive(Request $request)
    {
        $id =  $request->id;
        $status = $request->status;
        // dd($id);

        $EmpStatus = UsersAlam::find($id);

        $EmpStatus->status = 1;

        if ($EmpStatus->save()) {

            $return['code'] = 200;
            $return['msg'] = "Active Successfully";
            $return['data'] = $EmpStatus;
        } else {
            $return['code'] = 101;
            $return['msg'] = "Activation Failed";
        }
        return response()->json($return);
    }
    public function alarmDelete(Request $request)
    {
        $id = $request->id;
        // dd($id);

        $del  = UsersAlam::find($id);

        if ($del->delete()) {
            $return['code'] = 200;
            $return['msg'] = "Delete Alarm Successfully";
        } else {
            $return['code'] = 101;
            $return['msg'] = "Delete Alarm Failed";
        }
        return response()->json($return);
    }

    public function alarmUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'update_user_id' => "required",
                'update_id' => "required",
                'update_time_in_hr' => "required",
                'update_time_in_min' => "required",
                'update_status' => "required",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $id = $request->input('update_id');

        $alarmUpdate = UsersAlam::find($id);


        if (empty($alarmUpdate)) {

            $return['code'] = 101;
            $return['msg'] = 'Salary not found!';

            return response()->json($return);
        }
        $alarmUpdate->user_id = $request->input('update_user_id');
        $alarmUpdate->time_in_hr = $request->input('update_time_in_hr');
        $alarmUpdate->time_in_min = $request->input('update_time_in_min');
        $alarmUpdate->created_at = date('Y-m-d H:i:s');
        $alarmUpdate->status = $request->input('update_status');

        if ($alarmUpdate->save()) {
            $return['code'] = 200;
            $return['msg'] = 'Alarm has been Updated.';
        } else {
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }

        return response()->json($return);
    }

    public function getDetails()
    {
        $users = Users::where('username', '<>', 'admin')
            ->orderBy('post', 'ASC')
            ->orderBy('username', 'ASC')
            ->get();

        return view('admin.manage_alarm.manage_alarm_details', ['users' => $users]);
    }

    public function getAlarmDetails(Request $request)
    {
        $date = $request->date;
        //  dd($date);
        $getDetail = UsersAlarmRecord::whereDate('date', '=', $date)->get();
        //  dd($getDetail);
        foreach ($getDetail as $row) {
            $row->username = $row->username->get();
        }

        if ($getDetail) {
            $return['code'] = 200;
            $return['msg'] = 'Data Found';
            $return['data'] = $getDetail;
        } else {
            $return['code'] = 101;
            $return['msg'] = 'Data Not Found';
        }

        return response()->json($return);
    }
}
