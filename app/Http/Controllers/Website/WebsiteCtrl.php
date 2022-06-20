<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class WebsiteCtrl extends Controller
{
    /**
     * Create Site Form
     */

    public function addSiteForm()
    {
        return view('admin.website.add_website');
    }


    /**
     * Insert New Site
     */
    public function addNewSite(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'site_name' => "required|unique:website_info,site_name|max:250",
                'site_url' => "required|unique:website_info,site_url|url|max:500",
                'site_category' => "required",
                'status' => "required",

            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $users = new Website();
        $users->site_name  = $request->input('site_name');
        $users->site_url = $request->input('site_url');
        $users->site_category = $request->input('site_category');
        $users->status = $request->input('status');
        if ($users->save()) {
            
            $return['code'] = 200;
            $return['msg'] = 'New Site has been added.';
        } else {
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }

        return response()->json($return);
    }


    /**
     * Fetch Site List
     */
    public function fetchSiteList()
    {
        $empSite = Website::orderBy('site_name', 'ASC')->get();

        $return['code'] = 200;
        $return['msg'] = 'New Site has been added.';
        $return['data'] = $empSite;

        return response()->json($return);
    }


    /**
     * Get Single Site Id
     */
    public function getSingleSiteId(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'id' => "required",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $id = $request->id;

        $user = Website::select('id', 'site_name')->find($id);

        $return['code'] = 200;
        $return['msg'] = 'data found';
        $return['data'] = $user;

        return response()->json($return);
    }


    /**
     * Update Site
     */
    public function updateSite(Request $request)
    {

        $id = $request->update_site_id;
        $site_url = $request->input('update_site_url');
        $site_name  = $request->input('update_site_name');

        $validator = Validator::make(
            $request->all(),
            [

                'update_site_name' => "required|unique:website_info,site_name,$id,id|max:250",
                'update_site_url' => "required|url|max:500",
                // 'update_site_url' => "required|unique:website_info,site_url,$id,id|url|max:500",
                'update_site_category' => "required",
                'update_status' => "required",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }



        $users = Website::find($id);

        if (empty($users)) {

            $return['code'] = 101;
            $return['msg'] = 'Site not found!';

            return response()->json($return);
        }

        $users->site_name  = $site_name;
        $users->site_url = $site_url;
        $users->site_category = $request->input('update_site_category');
        $users->status = $request->input('update_status');
        
        if ($users->save()) {
            $return['code'] = 200;
            $return['msg'] = 'Site has been Updated.';
        } else {
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }

        return response()->json($return);
    }

      /**
     * Delete Website
     */
    public function deleteSite(Request $request){

        $id = $request->input('id');

        $userDelele = Website::find($id);

        if($userDelele->delete()){
            $return['code'] = 200;
            $return['msg'] = 'Site has been Deleted.';
        }else{
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }
        return response()->json($return);

    }
}
