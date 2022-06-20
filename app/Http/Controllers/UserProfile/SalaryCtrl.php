<?php

namespace App\Http\Controllers\UserProfile;

use App\Http\Controllers\Controller;
use App\Models\UserSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function Ramsey\Uuid\v1;

class SalaryCtrl extends Controller
{
    public function fetchUserSalaryIdData($userId)
    {
        $userInfo = UserSalary::where('user_id', $userId)->get();

        // dd($userInfo);

        return view('admin.manage_salary.salary_manage', ['userId' => $userId, 'userInfo' => $userInfo]);
    }


    public function addNewSalary(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => "required",
                'salary' => "required",
                'created_at' => "required",

            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $user_id = $request->input('user_id');

        $userSalaryOld = UserSalary::where('user_id', $user_id)
            ->where('status', 1)->first();

        if (!empty($userSalaryOld)) {

            $userSalaryOld->status = 0;
            $userSalaryOld->last_date = date('Y-m-d');

            $userSalaryOld->save();
        }


        $users = new UserSalary();
        $users->user_id = $request->input('user_id');
        $users->salary = $request->input('salary');
        $users->created_at = $request->input('created_at');
        $users->status = 1;

        if ($users->save()) {
            $return['code'] = 200;
            $return['msg'] = 'Salary has been added.';
        } else {
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }

        return response()->json($return);
    }

    /**
     * Fetch all salary data
     */

    public function fetchAllSalary($userId)
    {
        $empDep = UserSalary::orderBy('salary', 'ASC')->where('user_id', $userId)->get();

        $return['code'] = 200;
        $return['msg'] = 'Data found.';
        $return['data'] = $empDep;

        return response()->json($return);
    }

     /**
     * Salary Updation 
     */
    public function updateSalary(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                
                'update_user_id' => "required",
                'update_id' => "required",
                'update_salary' => "required",
                'update_created_at' => "required",
                'update_last_date' => "required",
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
        
        $salary = UserSalary::find($id);


        if (empty($salary)) {

            $return['code'] = 101;
            $return['msg'] = 'Salary not found!';

            return response()->json($return);
        }
        $salary->user_id = $request->input('update_user_id');
        $salary->salary = $request->input('update_salary');
        $salary->created_at = $request->input('update_created_at');
        $salary->last_date = $request->input('update_last_date');
        $salary->status = $request->input('update_status');

        if ($salary->save()) {
            $return['code'] = 200;
            $return['msg'] = 'Salary has been Updated.';
        } else {
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }

        return response()->json($return);
    }

    /**
     * Delete Salary
     */
    public function deleteSalary(Request $request){

        $id = $request->input('id');

        $userDelele = UserSalary::find($id);

        if($userDelele->delete()){
            $return['code'] = 200;
            $return['msg'] = 'Salary has been Deleted.';
        }else{
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }
        return response()->json($return);

    }
}
