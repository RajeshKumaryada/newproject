<?php

namespace App\Http\Controllers\DepartmentManager;

use App\Http\Controllers\Controller;
use App\Models\EmpDepartment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentCtrl extends Controller
{
    
    /**
     * Create Department Form
     */
    
    public function addDepartment()
    {
        return view('admin.department_manager.manage_department');
    }


    /**
     * Insert New Department 
     */


    public function addNewDepartment(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'dep_name' => "required|unique:emp_department,dep_name|max:150",

            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $users = new EmpDepartment();
        $users->dep_name = $request->input('dep_name');

        if ($users->save()) {

            $return['code'] = 200;
            $return['msg'] = 'New Department has been added.';
        } else {
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }

        return response()->json($return);
    }



    /**
     * Fetch the of Department
     */

    public function fetchDepartmentList()
    {
        $empDep = EmpDepartment::orderBy('dep_name', 'ASC')->get();

        $return['code'] = 200;
        $return['msg'] = 'Data found.';
        $return['data'] = $empDep;

        return response()->json($return);
    }



    /**
     * Get Edit Department Id
     */

    public function getSingleId(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'id' => "required|max:150",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $id = $request->id;

        $user = EmpDepartment::select('dep_id', 'dep_name')->find($id);

        $return['code'] = 200;
        $return['msg'] = 'data found';
        $return['data'] = $user;

        return response()->json($return);
    }

    /**
     * Update Department
     */

    public function updateDepartment(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'update_dep_name' => "required|unique:emp_department,dep_name|max:150",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $id = $request->update_dep_id;

        $users = EmpDepartment::find($id);

        if (empty($users)) {
            
            $return['code'] = 101;
            $return['msg'] = 'Department not found!';

            return response()->json($return);
        }

        $users->dep_name = $request->input('update_dep_name');

        if ($users->save()) {
            $return['code'] = 200;
            $return['msg'] = 'Department has been Updated.';
        } else {
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }

        return response()->json($return);
    }

    /**
     * Delete Department
     */
    public function deleteDepartment(Request $request){

        $id = $request->input('id');

        $userDelele = EmpDepartment::find($id);

        if($userDelele->delete()){
            $return['code'] = 200;
            $return['msg'] = 'Department has been Deleted.';
        }else{
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }
        return response()->json($return);

    }


}
