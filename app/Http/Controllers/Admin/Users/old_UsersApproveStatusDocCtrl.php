<?php

namespace App\Http\Controllers\Admin\Users;

use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\UsersBankInfo;
use App\Models\UsersBankInfoTemp;
use App\Models\UsersDocument;
use App\Models\UsersDocumentTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersApproveStatusDocCtrl extends Controller
{

    /**
     * View File of Approve Status
     */
    public function viewApproveStatusDoc()
    {
        return view('admin.users.view_approve_status');
    }


    /**
     * Fetch Users Document Temporary 
     */
    public function fetchUsersDocTemp()
    {

        $usersDocTemp = UsersDocumentTemp::with('userName:username,user_id')->get();
        $usersBankInfoTempDoc = UsersBankInfoTemp::with('userName:username,user_id')->get();

        $return['code'] = 200;
        $return['msg'] = 'Data Found';
        $return['data'] = ['doc' => $usersDocTemp, 'bank' => $usersBankInfoTempDoc];

        return response()->json($return);
    }


    /**
     * Approve Users Document
     */
    public function approveUsersDoc(Request $request)
    {

        $status = $request->status;
        $id = $request->id;

        $userinsert = UsersDocumentTemp::find($id);
        if ($status == 1) {

            $userDocoriginal = UsersDocument::where('id', $userinsert->user_doc_id)->first();

            $userDocoriginal->images = $userinsert->images;
            $userDocoriginal->type = $userinsert->type;

            if ($userDocoriginal->save()) {
                $return['code'] = 200;
                $return['msg'] = "Approved Saved";
            }

            $userinsert->status = 1;
            $userinsert->remark = "Approved";

            if ($userinsert->delete()) {

                $return['code'] = 200;
                $return['msg'] = "Approved";
            }

            return response()->json($return);
        } else if ($status == 2) {
            $userinsert->status = 2;

            if ($userinsert->save()) {

                $return['code'] = 200;
                $return['msg'] = "Deny";
                $return['data'] = $userinsert;
            }
        } else {
            $return['code'] = 200;
            $return['msg'] = "Not Found";
        }
        return response()->json($return);
    }
    /**
     * Approve Users Bank Document
     */
    public function approveUsersBankDoc(Request $request)
    {

        $status = $request->status;
        $id = $request->id;
        $remark = $request->remark;
        
        $userBankInfoinsert = UsersBankInfoTemp::find($id);

        if ($status == 1) {

            $userBankInfooriginal = UsersBankInfo::where('id', $userBankInfoinsert->user_bank_info_id)->first();

            $userBankInfooriginal->passbook = $userBankInfoinsert->passbook;
            $userBankInfooriginal->bank_name = $userBankInfoinsert->bank_name;
            $userBankInfooriginal->acc_no = $userBankInfoinsert->acc_no;
            $userBankInfooriginal->ifsc = $userBankInfoinsert->ifsc;

            if ($userBankInfooriginal->save()) {
                $return['code'] = 200;
                $return['msg'] = "Bank Info Approved";
            }

            // $userBankInfoinsert->status = 1;

            // $userBankInfoinsert->remark = "Approved";

            if ($userBankInfoinsert->delete()) {

                $return['code'] = 200;
                $return['msg'] = "Approved Deleted";
            }


            return response()->json($return);
        } else if ($status == 2) {

            $userBankInfoinsert->status = 2;
            $userBankInfoinsert->remark = $remark;

            if ($userBankInfoinsert->save()) {

                $return['code'] = 200;
                $return['msg'] = "Bank Info Deny";
                $return['data'] = $userBankInfoinsert;
            }
        } else {
            $return['code'] = 200;
            $return['msg'] = "Not Found";
        }
        return response()->json($return);
    }


    /**
     * Update Document User Remark
     */
    public function updateUsersRemark(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            [
                //  'id' => "required|max:150",
                'remark' => "required",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $id = $request->id;
        $bank_id = $request->bank_id;
      
        if (!empty($id)) {
            $remark = $request->remark;
            $userinsert = UsersDocumentTemp::find($id);
            $userinsert->remark = $remark;

            if ($userinsert->save()) {
                $return['code'] = 200;
                $return['msg'] = 'Remark Inserted';
                $return['data'] = $userinsert;
            }

            return response()->json($return);
        } else if (!empty($bank_id)) {
            $remark = $request->remark;
            $userBankInsert = UsersBankInfoTemp::find($bank_id);
            

            $userBankInsert->remark = $remark;

            if ($userBankInsert->save()) {
                $return['code'] = 200;
                $return['msg'] = 'Bank Remark Inserted';
                $return['data'] = $userBankInsert;
            }
            return response()->json($return);
        }
    }

    /**
     * Update Bank Document Remark
     */
    public function updateUsersBankRemark(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                //  'id' => "required|max:150",
                'remark' => "required",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $id = $request->id;
        $bank_id = $request->bank_id;
        
        if (!empty($id)) {

            $remark = $request->remark;
            $userBankinsert = UsersBankInfoTemp::find($id);
            $userBankinsert->remark = $remark;

            if ($userBankinsert->save()) {
                $return['code'] = 200;
                $return['msg'] = 'Remark Bank Inserted';
                $return['data'] = $userBankinsert;
            }
            return response()->json($return);
        }
    }


    /**
     * Fetch Users Document Remark
     */
    public function fetchUsersRemark(Request $request)
    {

        $id = $request->id;
        $dataRemark = UsersDocumentTemp::find($id);
        $return['code'] = 200;
        $return['msg'] = "Data Found";
        $return['dataremark'] = $dataRemark;
        return response()->json($return);
    }


    /**
     * Fetch Users Bank Info Remark
     */
    public function fetchUsersBankInfoRemark(Request $request)
    {
        $id = $request->bank_id;
        $dataBankRemark = UsersBankInfoTemp::find($id);
        $return['code'] = 200;
        $return['msg'] = "Data Found";
        $return['dataremark'] = $dataBankRemark;
        return response()->json($return);
    }

    public function getbagesDocument(){

        $userDoc = UsersDocumentTemp::where('status',0)->count();
        $userBank = UsersBankInfoTemp::where('status',0)->count();
        
        return $userDoc + $userBank;
    }
}
