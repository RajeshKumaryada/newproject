<?php

namespace App\Http\Controllers\UserProfile;

use App\Http\Controllers\Controller;
use App\Models\UserBankInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserBankInfoCtrl extends Controller
{

    /**
     * Fetch Bank Info Data 
     */
    public function fetchBankInfoIdAData($userId)
    {
        $userInfo = UserBankInfo::where('user_id', $userId)->first();

        return view('admin.bank_info_manage.manage_user_bank_info', ['userId' => $userId, 'userInfo' => $userInfo]);
    }


    /**
     * Add New Bank Info
     */

    public function addNewBankInfo(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => "required|max:10",
                'bank_name' => "required|max:250",
                'acc_no' => "required|max:25",
                'ifsc' => "required|max:25",
                'status' => "required",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }


        $option = new UserBankInfo();
        $option->user_id = $request->input('user_id');
        $option->bank_name = $request->input('bank_name');
        $option->acc_no = $request->input('acc_no');
        $option->ifsc = $request->input('ifsc');
        $option->status = $request->input('status');


        if (empty($option)) {

            $return['code'] = 101;
            $return['msg'] = 'Bank Detail not found!';

            return response()->json($return);
        }


        if ($option->save()) {

            $return['code'] = 200;
            $return['msg'] = 'Bank Detail Inserted.';
        } else {

            $return['code'] = 101;
            $return['msg'] = ' not found!';
        }

        return response()->json($return);
    }


    /**
     * Bank Info Update
     */
    public function addNewBankInfoupdate(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'bank_name' => "required|max:250",
                'acc_no' => "required|max:25",
                'ifsc' => "required|max:25",
                'status' => "required",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $id = $request->input('pid');

        $option = UserBankInfo::where('id', $id)->first();

        $option->bank_name = $request->input('bank_name');
        $option->acc_no = $request->input('acc_no');
        $option->ifsc = $request->input('ifsc');
        $option->status = $request->input('status');


        if (empty($option)) {

            $return['code'] = 101;
            $return['msg'] = 'Bank Info Not Update';

            return response()->json($return);
        }


        if ($option->save()) {

            $return['code'] = 200;
            $return['msg'] = 'Bank Info Detail Updated.';
        } else {

            $return['code'] = 101;
            $return['msg'] = 'Bank Info detail not found!';
        }

        return response()->json($return);
    }
}
