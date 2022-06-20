<?php

namespace App\Http\Controllers\DesignationManager;

use App\Http\Controllers\Controller;
use App\Models\EmpDesignation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DesignationCtrl extends Controller
{

    /**
     * Create Designation Form
     */
    public function addDesignation()
    {
        return view('admin.designation_manager.manage_designation');
    }



    /**
     * Insert New Designation
     */
    public function addNewDesignation(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'des_name' => "required|unique:emp_designation,des_name|max:150",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $users = new EmpDesignation();
        $users->des_name = $request->input('des_name');

        if ($users->save()) {

            $return['code'] = 200;
            $return['msg'] = 'New Designation has been added.';
        } else {
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }

        return response()->json($return);
    }


    /**
     * Fetch Designation List
     * 
     */
    public function fetchDesignationList()
    {
        $empDes = EmpDesignation::orderBy('des_name', 'ASC')->get();

        $return['code'] = 200;
        $return['msg'] = 'New Designation has been added.';
        $return['data'] = $empDes;

        return response()->json($return);
    }


    /**
    * Get Single Id Designation
    */
    public function getSingledesigId(Request $request)
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

        $user = EmpDesignation::select('des_id', 'des_name')->find($id);

        $return['code'] = 200;
        $return['msg'] = 'data found';
        $return['data'] = $user;

        return response()->json($return);
    }


    /**
     * Designation Updation 
     */
    public function updateDesignation(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'update_des_name' => "required|unique:emp_designation,des_name|max:150",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $id = $request->update_des_id;

        $users = EmpDesignation::find($id);

        if (empty($users)) {

            $return['code'] = 101;
            $return['msg'] = 'Designation not found!';

            return response()->json($return);
        }

        $users->des_name = $request->input('update_des_name');

        if ($users->save()) {
            $return['code'] = 200;
            $return['msg'] = 'Designation has been Updated.';
        } else {
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }

        return response()->json($return);
    }
    /**
     * Delete Designation
     */
    public function deleteDesignation(Request $request){

        $id = $request->input('id');

        $userDelele = EmpDesignation::find($id);

        if($userDelele->delete()){
            $return['code'] = 200;
            $return['msg'] = 'Designation has been Deleted.';
        }else{
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }
        return response()->json($return);

    }
}
