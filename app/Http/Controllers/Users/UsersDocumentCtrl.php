<?php

namespace App\Http\Controllers\Users;

use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use App\Models\UserAddressTemp;
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


        // Add Address

        $addressData = [];

        $addressData = [
            [
                'user_id'            => $userId,
                'address_line_one'   => $request->input('local_address_line_one'),
                'address_line_two'   => $request->input('local_address_line_two'),
                'city'               => $request->input('local_city'),
                'address_type'       =>  1,
                'state'              => $request->input('local_state'),
                'country'            => $request->input('local_country'),
                'postal_address'     => $request->input('local_postal_address'),

            ],
            [
                'user_id'            => $userId,
                'address_line_one'   => $request->input('permanent_address_line_one'),
                'address_line_two'   => $request->input('permanent_address_line_two'),
                'city'               => $request->input('permanent_city'),
                'address_type'       =>  2,
                'state'              => $request->input('permanent_state'),
                'country'            => $request->input('permanent_country'),
                'postal_address'     => $request->input('permanent_postal_address'),

            ]
        ];

        $userAddress = UserAddress::insert($addressData);
        $imgdata = UsersDocument::insert($imageData);
        $bankD = UserBankInfo::insert($bankData);


        if ($imgdata == 1 && $bankD == 1 && $userAddress == 1) {

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
    // public function fetchDoc()
    // {

    //     $userId = TrackSession::get()->userId();

    //     $userDocs = UsersDocument::where('user_id', $userId)->get();

    //     // dd($userDocs);

    //     $passbook = UserBankInfo::where('user_id', $userId)->first();

    //     $bankinfo = UserBankInfo::where('user_id', $userId)->first();


    //     $userDocInfoTemp = UsersDocumentTemp::select('user_id', 'type', 'images')->where('user_id', $userId)->get();


    //     // dd($doc);
    //     return view('users_documents.view_users_doc', [
    //         'userDocs' => $userDocs,
    //         'passbook' => $passbook,
    //         'bankinfo' => $bankinfo,
    //     ]);
    // }

    public function fetchDoc()
    {

        $userId = TrackSession::get()->userId();

        $userDocs = UsersDocument::where('user_id', $userId)->get();

        // dd($userDocs);

        $passbook = UserBankInfo::where('user_id', $userId)->first();

        $bankinfo = UserBankInfo::where('user_id', $userId)->first();

        $userAddress = UserAddress::where('user_id', $userId)->get();
        $userAddressTempStatusLocal = UserAddressTemp::where('user_id', $userId)->where('status', '2')->where('address_type', '1')->get();
        $userAddressTempStatusPerm = UserAddressTemp::where('user_id', $userId)->where('status', '2')->where('address_type', '2')->get();
        $userAddressTemp = UserAddressTemp::where('user_id', $userId)->get();
        $userAddressTempCount = UserAddressTemp::where('user_id', $userId)->get()->count();
        $countAddressLocalTemp = UserAddressTemp::where('user_id', $userId)->where('address_type', '1')->where('status', '3')->get()->count();
        $countAddressPerTemp = UserAddressTemp::where('user_id', $userId)->where('address_type', '2')->where('status', '3')->get()->count();
        $countAddressLocalTempDeny = UserAddressTemp::where('user_id', $userId)->where('address_type', '1')->where('status', '2')->get()->count();
        $countAddressPermTempDeny = UserAddressTemp::where('user_id', $userId)->where('address_type', '2')->where('status', '2')->get()->count();
        $countAddressPerTemp = UserAddressTemp::where('user_id', $userId)->where('address_type', '2')->where('status', '3')->get()->count();
        $userDocInfoTemp = UsersDocumentTemp::select('user_id', 'type', 'images')->where('user_id', $userId)->get();
        $vacDataOneCount = UserVaccinateDoc::select('type','file')->orderBy('id','DESC')->where('user_id',$userId)->where('type','1')->get()->count();
        $vacDataTwoCount = UserVaccinateDoc::select('type','file')->orderBy('id','DESC')->where('user_id',$userId)->where('type','2')->get()->count();
        $vacDataOneData = UserVaccinateDoc::select('type','file')->orderBy('id','DESC')->where('user_id',$userId)->where('type','1')->get();
        $vacDataTwoData = UserVaccinateDoc::select('type','file')->orderBy('id','DESC')->where('user_id',$userId)->where('type','2')->get();
        //   dd($vacDataTwoData);
        //  dd($userAddress);
        return view('users_documents.view_users_doc', [
            'userDocs'    => $userDocs,
            'passbook'    => $passbook,
            'bankinfo'    => $bankinfo,
            'userAddress' => $userAddress,
            'userAddressTemp' => $userAddressTemp,
            'userAddressTempCount' =>  $userAddressTempCount,
            'userAddressTempStatusLocal' =>  $userAddressTempStatusLocal,
            'userAddressTempStatusPerm' =>  $userAddressTempStatusPerm,
            'countAddressLocalTemp' => $countAddressLocalTemp,
            'countAddressPerTemp' => $countAddressPerTemp,
            'countAddressLocalTempDeny' => $countAddressLocalTempDeny,
            'countAddressPermTempDeny' => $countAddressPermTempDeny,
            'vacDataOne' => $vacDataOneCount,
            'vacDataTwo' => $vacDataTwoCount,
            'vacDataOneData' => $vacDataOneData,
            'vacDataTwoData' => $vacDataTwoData

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

    public function insertUserAddressLocalTemp(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'update_user_id'                    => "required",
                'update_local_address_line_one'     => "required|max:500",
                'update_local_address_line_two'     => "required|max:500",
                'update_local_city'                 => "required|max:500",
                'update_local_state'                => "required",
                'update_local_country'              => "required",
                'update_local_postal_address'       => "required",

            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }


        $users_address_local_id  = $request->input('local_id');
        $user_id           = $request->input('update_user_id');
        $address_line_one  = $request->input('update_local_address_line_one');
        $address_line_two  = $request->input('update_local_address_line_two');
        $city               = $request->input('update_local_city');
        $address_type        =  1;
        $state               = $request->input('update_local_state');
        $country            = $request->input('update_local_country');
        $postal_address     = $request->input('update_local_postal_address');


        $update = new UserAddressTemp();
        $update->users_address_id = $users_address_local_id;
        $update->user_id = $user_id;
        $update->address_line_one = $address_line_one;
        $update->address_line_two = $address_line_two;
        $update->city  = $city;
        $update->address_type = $address_type;
        $update->state =  $state;
        $update->country = $country;
        $update->postal_address = $postal_address;
        $update->status = 3;



        if ($update->save()) {

            $return['code'] = 200;
            $return['msg'] = 'Update Local Address in process wait for approval.';
        } else {

            $return['code'] = 101;
            $return['msg'] = 'Address not found!';
        }

        return response()->json($return);
    }

    /**
     * Temp data updated
     */
    public function updateTempDataLocal(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'update_user_id'                    => "required",
                'update_local_address_line_one'     => "required|max:500",
                'update_local_address_line_two'     => "required|max:500",
                'update_local_city'                 => "required|max:500",
                'update_local_state'                => "required",
                'update_local_country'              => "required",
                'update_local_postal_address'       => "required",

            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }


        $users_address_local_id  = $request->input('local_id');
        $user_id           = $request->input('update_user_id');
        $address_line_one  = $request->input('update_local_address_line_one');
        $address_line_two  = $request->input('update_local_address_line_two');
        $city               = $request->input('update_local_city');
        $address_type        =  1;
        $state               = $request->input('update_local_state');
        $country            = $request->input('update_local_country');
        $postal_address     = $request->input('update_local_postal_address');


        $update =  UserAddressTemp::find($users_address_local_id);
        $update->user_id = $user_id;
        $update->address_line_one = $address_line_one;
        $update->address_line_two = $address_line_two;
        $update->city  = $city;
        $update->address_type = $address_type;
        $update->state =  $state;
        $update->country = $country;
        $update->postal_address = $postal_address;
        $update->status = 3;



        if ($update->save()) {

            $return['code'] = 200;
            $return['msg'] = 'Update Local Address in process wait for approval.';
        } else {

            $return['code'] = 101;
            $return['msg'] = 'Address not found!';
        }

        return response()->json($return);
    }

    public function updateTempDataPerm(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'update_user_id'                    => "required",
                'update_permanent_address_line_one'     => "required|max:500",
                'update_permanent_address_line_two'     => "required|max:500",
                'update_permanent_city'                 => "required|max:500",
                'update_permanent_state'                => "required",
                'update_permanent_country'              => "required",
                'update_permanent_postal_address'       => "required",

            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }


        $users_address_permanent_id  = $request->input('permanent_id');
        $user_id           = $request->input('update_user_id');
        $address_line_one  = $request->input('update_permanent_address_line_one');
        $address_line_two  = $request->input('update_permanent_address_line_two');
        $city               = $request->input('update_permanent_city');
        $address_type        =  2;
        $state               = $request->input('update_permanent_state');
        $country            = $request->input('update_permanent_country');
        $postal_address     = $request->input('update_permanent_postal_address');


        $update =  UserAddressTemp::find($users_address_permanent_id);
        $update->user_id = $user_id;
        $update->address_line_one = $address_line_one;
        $update->address_line_two = $address_line_two;
        $update->city  = $city;
        $update->address_type = $address_type;
        $update->state =  $state;
        $update->country = $country;
        $update->postal_address = $postal_address;
        $update->status = 3;



        if ($update->save()) {

            $return['code'] = 200;
            $return['msg'] = 'Update Local Address in process wait for approval.';
        } else {

            $return['code'] = 101;
            $return['msg'] = 'Address not found!';
        }

        return response()->json($return);
    }

    public function insertUserAddressPermanentTemp(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'update_user_id'                    => "required",
                'update_permanent_address_line_one' => "required|max:500",
                'update_permanent_address_line_two' => "required|max:500",
                'update_permanent_city'             => "required|max:500",
                'update_permanent_state'            => "required",
                'update_permanent_country'          => "required",
                'update_permanent_postal_address'   => "required",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }


        $users_address_permanent_id  = $request->input('permanent_id');
        $user_id            = $request->input('update_user_id');
        $address_line_one   = $request->input('update_permanent_address_line_one');
        $address_line_two   = $request->input('update_permanent_address_line_two');
        $city               = $request->input('update_permanent_city');
        $address_type       =  2;
        $state              = $request->input('update_permanent_state');
        $country            = $request->input('update_permanent_country');
        $postal_address     = $request->input('update_permanent_postal_address');



        $update_per = new UserAddressTemp();
        $update_per->users_address_id = $users_address_permanent_id;
        $update_per->user_id = $user_id;
        $update_per->address_line_one = $address_line_one;
        $update_per->address_line_two = $address_line_two;
        $update_per->city  = $city;
        $update_per->address_type = $address_type;
        $update_per->state =  $state;
        $update_per->country = $country;
        $update_per->postal_address = $postal_address;
        $update_per->status = 3;


        if ($update_per->save()) {

            $return['code'] = 200;
            $return['msg'] = 'Update Permanent Address in process wait for approval.';
        } else {

            $return['code'] = 101;
            $return['msg'] = 'Address not found!';
        }

        return response()->json($return);
    }

    public function denyUserAddressTemp(Request $request)
    {
        $id = $request->id;
        $users_address_local_id = $request->input('local_id');
        // dd($users_address_local_id);
        if (!empty($users_address_local_id)) {

            $user_id            = $request->input('update_user_id');
            $address_line_one   = $request->input('update_local_address_line_one');
            $address_line_two   = $request->input('update_local_address_line_two');
            $city               = $request->input('update_local_city');
            $address_type       =  2;
            $state              = $request->input('update_local_state');
            $country            = $request->input('update_local_country');
            $postal_address     = $request->input('update_local_postal_address');

            $update = UserAddressTemp::find($users_address_local_id);

            $update->user_id =  $user_id;
            $update->address_line_one = $address_line_one;
            $update->address_line_two = $address_line_two;
            $update->city  = $city;
            $update->address_type = $address_type;
            $update->state  = $state;
            $update->country = $country;
            $update->postal_address = $postal_address;
            if ($update->save()) {

                $return['code'] = 200;
                $return['msg'] = 'Update in process wait for approval.';
            } else {

                $return['code'] = 101;
                $return['msg'] = 'Address not found!';
            }
        } else {
            $users_address_per_id   = $request->input('permanent_id');
            $user_id            = $request->input('update_user_id');
            $address_line_one   = $request->input('update_permanent_address_line_one');
            $address_line_two   = $request->input('update_permanent_address_line_two');
            $city               = $request->input('update_permanent_city');
            $address_type       =  2;
            $state              = $request->input('update_permanent_state');
            $country            = $request->input('update_permanent_country');
            $postal_address     = $request->input('update_permanent_postal_address');


            $update_per = UserAddressTemp::find($users_address_per_id);
            $update_per->user_id =  $user_id;
            $update_per->address_line_one = $address_line_one;
            $update_per->address_line_two = $address_line_two;
            $update_per->city  = $city;
            $update_per->address_type = $address_type;
            $update_per->state  = $state;
            $update_per->country = $country;
            $update_per->postal_address = $postal_address;
            // dd($update_per);
            if ($update_per->save()) {

                $return['code'] = 200;
                $return['msg'] = 'Update in process wait for approval.';
            } else {

                $return['code'] = 101;
                $return['msg'] = 'Address not found!';
            }
        }


        return response()->json($return);
    }

    /**
     * Add First Dose
     */
    public function addVaccineFormDoseOne(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'type' => "numeric",
                'vac_certificate_one' => "required|mimes:jpeg,jpg,png,pdf",

            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $userId = TrackSession::get()->userId();

        $type =  $request->type;
        $images = $request->file('vac_certificate_one');
        // $imageData = [];



        if (!empty($images)) {

            $imgVaccineDoc =  $images->storePublicly('user_documents', 'public');

            $userId = TrackSession::get()->userId();

            $addVaccine = new UserVaccinateDoc();
            $addVaccine->user_id = $userId;
            $addVaccine->type = $type;
            $addVaccine->file = $imgVaccineDoc;

            if ($addVaccine->save()) {
                $return['code'] = 200;
                $return['msg'] = 'Vaccine Added Successfully.';
            } else {
                $return['code'] = 101;
                $return['msg'] = 'Please contact administration';
            }

            return response()->json($return);
        }
    }

    /**
     * Add Second Dose
     */
    public function addVaccineFormDoseTwo(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'type' => "numeric",
                'vac_certificate_two' => "required|mimes:jpeg,jpg,png,pdf",

            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $userId = TrackSession::get()->userId();

        $type =  $request->type;
        $images = $request->file('vac_certificate_two');
        // $imageData = [];



        if (!empty($images)) {

            $imgVaccineDoc =  $images->storePublicly('user_documents', 'public');

            $userId = TrackSession::get()->userId();

            $addVaccine = new UserVaccinateDoc();
            $addVaccine->user_id = $userId;
            $addVaccine->type = $type;
            $addVaccine->file = $imgVaccineDoc;

            if ($addVaccine->save()) {
                $return['code'] = 200;
                $return['msg'] = 'Vaccine Added Successfully.';
            } else {
                $return['code'] = 101;
                $return['msg'] = 'Please contact administration';
            }

            return response()->json($return);
        }
    }


    // public function fetchVacDataOne()
    // {
    //     $userId = TrackSession::get()->userId();
    //     $vacDataOne = UserVaccinateDoc::select('type','file')->orderBy('id','DESC')->where('user_id',$userId)->first();

    //     if($vacDataOne){
    //         $return['code'] = 200;
    //         $return['msg'] = 'Data Found.';
    //         $return['data'] = $vacDataOne;
    //     }else{
    //         $return['code'] = 101;
    //         $return['msg'] = 'Not Found';
    //     }
    //     return view('users_documents.view_users_doc', []);

    // }
    // public function fetchVacDataTwo()
    // {
    //     $userId = TrackSession::get()->userId();
    //     $vacDataTwo = UserVaccinateDoc::select('type','file')->orderBy('id','DESC')->where('user_id',$userId)->first();
        
    //     if($vacDataTwo){
    //         $return['code'] = 200;
    //         $return['msg'] = 'Data Found.';
    //         $return['data'] = $vacDataTwo;
    //     }else{
    //         $return['code'] = 101;
    //         $return['msg'] = 'Not Found';
    //     }
    //     return view('users_documents.view_users_doc', []);
    // }
}
