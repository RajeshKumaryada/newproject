<?php

namespace App\Http\Controllers\UserProfile;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserAddressCtrl extends Controller
{
    /**
     * Fetch User address Data 
     */
    public function fetchUserAddressIdData($userId)
    {
        $userInfo = UserAddress::where('user_id', $userId)->get();

        // dd($userInfo);

        return view('admin.user_address.address_user', ['userId' => $userId, 'userInfo' => $userInfo]);
    }


    /**
     * Add User Address
     */
    public function addNewAddress(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'user_id'                    => "required",
                'local_address_line_one'     => "required|max:500",
                'local_address_line_two'     => "required|max:500",
                'local_city'                 => "required|max:500",
                'local_state'                => "required",
                'local_country'              => "required",
                'local_postal_address'       => "required",
                'permanent_address_line_one' => "required|max:500",
                'permanent_address_line_two' => "required|max:500",
                'permanent_city'             => "required|max:500",
                'permanent_state'            => "required",
                'permanent_country'          => "required",
                'permanent_postal_address'   => "required",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }


        $data = [
            [
                'user_id'            => $request->input('user_id'),
                'address_line_one'   => $request->input('local_address_line_one'),
                'address_line_two'   => $request->input('local_address_line_two'),
                'city'               => $request->input('local_city'),
                'address_type'       =>  1,
                'state'              => $request->input('local_state'),
                'country'            => $request->input('local_country'),
                'postal_address'     => $request->input('local_postal_address'),

            ],
            [
                'user_id'            => $request->input('user_id'),
                'address_line_one'   => $request->input('permanent_address_line_one'),
                'address_line_two'   => $request->input('permanent_address_line_two'),
                'city'               => $request->input('permanent_city'),
                'address_type'       =>  2,
                'state'              => $request->input('permanent_state'),
                'country'            => $request->input('permanent_country'),
                'postal_address'     => $request->input('permanent_postal_address'),

            ]
        ];


        if (UserAddress::insert($data)) {

            $return['code'] = 200;
            $return['msg'] = 'User Address Inserted.';
        } else {

            $return['code'] = 101;
            $return['msg'] = 'User Address not found!';
        }

        return response()->json($return);
    }


    /**
     * User Address Update
     */
    public function addNewAddressupdate(Request $request)
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

        $data = [
            [
                'id'                 => $request->input('local_id'),
                'user_id'            => $request->input('update_user_id'),
                'address_line_one'   => $request->input('update_local_address_line_one'),
                'address_line_two'   => $request->input('update_local_address_line_two'),
                'city'               => $request->input('update_local_city'),
                'address_type'       =>  1,
                'state'              => $request->input('update_local_state'),
                'country'            => $request->input('update_local_country'),
                'postal_address'     => $request->input('update_local_postal_address'),

            ],
            [
                'id'                 => $request->input('permanent_id'),
                'user_id'            => $request->input('update_user_id'),
                'address_line_one'   => $request->input('update_permanent_address_line_one'),
                'address_line_two'   => $request->input('update_permanent_address_line_two'),
                'city'               => $request->input('update_permanent_city'),
                'address_type'       =>  2,
                'state'              => $request->input('update_permanent_state'),
                'country'            => $request->input('update_permanent_country'),
                'postal_address'     => $request->input('update_permanent_postal_address'),

            ]
        ];

        $update = UserAddress::upsert($data, ['address_line_one', 'address_line_two', 'city', 'state', 'country', 'postal_address']);

        if ($update > 0) {

            $return['code'] = 200;
            $return['msg'] = 'Address Updated.';
        } else {

            $return['code'] = 101;
            $return['msg'] = 'Address not found!';
        }

        return response()->json($return);
    }

}
