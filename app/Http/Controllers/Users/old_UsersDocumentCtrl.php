<?php

namespace App\Http\Controllers\Users;

use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\UserBankInfo;
use App\Models\Users;
use App\Models\UsersBankInfo;
use App\Models\UsersBankInfoTemp;
use App\Models\UsersDocument;
use App\Models\UsersDocumentTemp;
use App\Models\UserVaccinateDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UsersDocumentCtrl extends Controller
{


    /**
     *  Documents Form 
     */
    public function addDocForm()
    {
        $count = UsersDocument::where('user_id', TrackSession::get()->userId())->count();

        if ($count > 0) {
            return redirect('users/employee-documents/getdata');
        }

        return view('users_documents.manage_users_doc');
    }

    /**
     * Submit Documents 
     */
    public function addDocSubmit(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'profile' => "required|mimes:jpg,jpeg,png,pdf",
                'id_proof' => "required|mimes:jpg,jpeg,png,pdf",
                'local_address' => "",
                'permanent_address' => "required|mimes:jpg,jpeg,png,pdf",
                'images.0' => "required||mimes:jpg,jpeg,png,pdf",
                'educ.0' => "required",
                'exp_certificate' => "",
                'passbook' => "required|mimes:jpg,jpeg,png,pdf",
                'bank_name' => "required",
                'acc_no' => "required",
                'ifsc' => "required",

            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }




        $id_proof = $request->file('id_proof');
        $local_address = $request->file('local_address');
        $permanent_address = $request->file('permanent_address');
        $images = $request->file('images');

        $exp_certificate = $request->file('exp_certificate');

        $userId = TrackSession::get()->userId();

        $imageData = [];



        if (!empty($request->file('profile'))) {
            $profile = $request->file('profile');


            $image1 =  $profile->storePublicly('user_documents', 'public');

            // dd($image);
            $imageData[] = [
                'user_id' => $userId,
                'type' => "profile",
                'images' => $image1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        if (!empty($request->file('id_proof'))) {
            $id_proof = $request->file('id_proof');
            // $imageData = [];

            $image2 =  $id_proof->storePublicly('user_documents', 'public');

            $imageData[] = [
                'user_id' => $userId,
                'type' => "id_proof",
                'images' => $image2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        if (!empty($request->file('local_address'))) {

            $local_address = $request->file('local_address');
            // $imageData = [];

            $image3 =   $local_address->storePublicly('user_documents', 'public');

            $imageData[] = [
                'user_id' => $userId,
                'type' => "local_address",
                'images' => $image3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        if (!empty($request->file('permanent_address'))) {

            $permanent_address = $request->file('permanent_address');
            // $imageData = [];

            $image4 =  $permanent_address->storePublicly('user_documents', 'public');

            $imageData[] = [
                'user_id' => $userId,
                'type' => "permanent_address",
                'images' => $image4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        if (!empty($request->file('exp_certificate'))) {

            $exp_certificate = $request->file('exp_certificate');
            // $imageData = [];

            $image5 =  $exp_certificate->storePublicly('user_documents', 'public');

            $imageData[] = [
                'user_id' => $userId,
                'type' => "exp_certificate",
                'images' => $image5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }


        if ($request->hasfile('images')) {

            // $imageData = [];
            // $img_id = uniqid();
            $educ = $request->input('educ');

            foreach ($request->file('images') as $idx => $file) {

                $image6 = $file->storePublicly('user_documents', 'public');

                $imageData[] = [
                    'user_id' => $userId,
                    'type' => $educ[$idx],
                    'images' => $image6,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
        }


        $bankData = [];

        if (!empty($request->file('passbook'))) {

            $passbook = $request->file('passbook');
            // $imageData = [];

            $image5 =  $passbook->storePublicly('user_documents', 'public');

            $bank_name = $request->input('bank_name');

            $acc_no = $request->input('acc_no');

            $ifsc = $request->input('ifsc');


            $bankData[] = [
                'user_id' => $userId,
                'passbook' => $image5,
                'bank_name' => "$bank_name",
                'acc_no' => $acc_no,
                'ifsc' => $ifsc,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }


        $imgdata = UsersDocument::insert($imageData);
        $bankD = UserBankInfo::insert($bankData);


        if ($imgdata == 1 && $bankD == 1) {

            $return['code'] = 200;
            $return['msg'] = 'Documents has been added.';
        } else {
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }

        return response()->json($return);
    }


    /**
     * Fetch document user
     */
    public function fetchDoc()
    {

        $userId = TrackSession::get()->userId();

        $userDocs = UsersDocument::where('user_id', $userId)->get();

        // dd($userDocs);

        $passbook = UserBankInfo::where('user_id', $userId)->first();

        $bankinfo = UserBankInfo::where('user_id', $userId)->first();


        $userDocInfoTemp = UsersDocumentTemp::select('user_id', 'type', 'images')->where('user_id', $userId)->get();


        // dd($doc);
        return view('users_documents.view_users_doc', [
            'userDocs' => $userDocs,
            'passbook' => $passbook,
            'bankinfo' => $bankinfo,
        ]);
    }


    /**
     * Render Web Images
     */
    public function renderDocumentImage($folder, $img_id)
    {

        if (Storage::disk('public')->exists("{$folder}/{$img_id}")) {
            $headers = array(
                'Content-Disposition' => 'inline',
            );
            $img = Storage::download("public/{$folder}/{$img_id}", null, $headers);

            return $img;
        } else {
            return abort(404);
        }
    }



    /**
     * Document Update
     */
    // public function viewForUpdateDoc()
    // {

    //     return view('users_documents.view_users_doc');
    // }

    public function insertDocTempImage(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'type' => "required",
                'images' => "required|mimes:jpeg,jpg,png,pdf",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $ImgDataTemp = [];

        $userId = TrackSession::get()->userId();
        $type = $request->input('type');


        $userDocs = UsersDocumentTemp::where('user_id', $userId)
            ->where('type', $type)
            ->first();


        if (empty($userDocs)) {
            $userDocs = new UsersDocumentTemp();
        }

        if (!empty($request->file('images'))) {
            $user_doc_id = $request->input('id');

            $images = $request->file('images');
            // $imageData = [];

            $imgDoc =  $images->storePublicly('user_documents', 'public');


            // $ImgDataTemp[] = [
            //     'user_doc_id' => $user_doc_id,
            //     'user_id' => $userId,
            //     'type' => $type,
            //     'images' => $imgDoc,
            //     'status' => 0,
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s'),
            // ];




            $userDocs->user_doc_id = $user_doc_id;
            $userDocs->user_id = $userId;
            $userDocs->type = $type;
            $userDocs->images = $imgDoc;
            $userDocs->status = 0;
            $userDocs->remark = '';
            $userDocs->created_at = date('Y-m-d H:i:s');
            $userDocs->updated_at = date('Y-m-d H:i:s');


            // $insertTempData = UsersDocumentTemp::insert($ImgDataTemp);
            // if ($insertTempData) {
            if ($userDocs->save()) {

                $return['code'] = 200;
                $return['msg'] = 'We are consern your request. Wait for approval.';
                $return['type'] = $type;
            } else {
                $return['code'] = 101;
                $return['msg'] = 'Please contact administration';
            }

            return response()->json($return);
        }
    }

    public function insertBankInfoTemp(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'passbook' => "required|mimes:jpeg,jpg,png,pdf",
                'bank_name' => "required",
                'acc_no' => "required",
                'ifsc' => "required",

            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $userId = TrackSession::get()->userId();
        $userBankDocs = UsersBankInfoTemp::where('user_id', $userId)->first();


        if (empty($userBankDocs)) {
            $userBankDocs = new UsersBankInfoTemp();
        }


        if (!empty($request->file('passbook'))) {
            $user_bank_info_id = $request->input('id');
            $bank_name = $request->input('bank_name');
            $acc_no = $request->input('acc_no');
            $ifsc = $request->input('ifsc');
            $images = $request->file('passbook');
            // $imageData = [];

            $imgBankInfoDoc =  $images->storePublicly('user_documents', 'public');

            $userId = TrackSession::get()->userId();



            $userBankDocs->user_id = $userId;
            $userBankDocs->user_bank_info_id = $user_bank_info_id;
            $userBankDocs->passbook = $imgBankInfoDoc;
            $userBankDocs->bank_name = $bank_name;
            $userBankDocs->acc_no = $acc_no;
            $userBankDocs->ifsc = $ifsc;
            $userBankDocs->remark = '';
            $userBankDocs->status = 0;
            $userBankDocs->created_at = date('Y-m-d H:i:s');
            $userBankDocs->updated_at = date('Y-m-d H:i:s');


            // $insertTempData = UsersBankInfoTemp::insert($bankDataTemp);
            if ($userBankDocs->save()) {
                $return['code'] = 200;
                $return['msg'] = 'We are consern your request. Wait for approval.';
            } else {
                $return['code'] = 101;
                $return['msg'] = 'Please contact administration';
            }

            return response()->json($return);
        }
    }

    // public function dataIfexist()
    // {

    //     $userId = TrackSession::get()->userId();

    //     $userDocInfoTemp = UsersDocumentTemp::select('user_id', 'type', 'images')->where('user_id', $userId)->get();

    //     // dd($userDocInfoTemp);
    //     return view('users_documents.view_users_doc', ['userDocInfoTemp' => $userDocInfoTemp]);
    // }

  
}
