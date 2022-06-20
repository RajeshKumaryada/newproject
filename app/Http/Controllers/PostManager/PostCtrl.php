<?php

namespace App\Http\Controllers\PostManager;

use App\Http\Controllers\Controller;
use App\Models\EmpPost;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostCtrl extends Controller
{

    /**
     * Create Post Form
     */
    public function addPost()
    {
        return view('admin.post_manager.manage_post');
    }

    
    /**
     * Insert New Post
     */
    public function addNewPost(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'post_name' => "required|unique:emp_post,post_name|max:150",

            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $users = new EmpPost();
        $users->post_name = $request->input('post_name');

        if ($users->save()) {

            $return['code'] = 200;
            $return['msg'] = 'New Post has been added.';
        } else {
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }

        return response()->json($return);
    }


    /**
     * Fetch Post List
     */
    public function fetchPostList()
    {
        $empPost = EmpPost::orderBy('post_name', 'ASC')->get();

        $return['code'] = 200;
        $return['msg'] = 'New Post has been added.';
        $return['data'] = $empPost;

        return response()->json($return);
    }


    /**
     * Get Single Post Id
     */
    public function getSinglePostigId(Request $request)
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

        $user = EmpPost::select('dep_id', 'post_name')->find($id);

        $return['code'] = 200;
        $return['msg'] = 'data found';
        $return['data'] = $user;

        return response()->json($return);
    }


    /**
     * Update Post
     */
    public function updatePost(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'update_post_name' => "required|unique:emp_post,post_name|max:150",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $id = $request->update_post_id;

        $users = EmpPost::find($id);

        if (empty($users)) {
            
            $return['code'] = 101;
            $return['msg'] = 'Post not found!';

            return response()->json($return);
        }

        $users->post_name = $request->input('update_post_name');

        if ($users->save()) {
            $return['code'] = 200;
            $return['msg'] = 'Post has been Updated.';
        } else {
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }

        return response()->json($return);
    }
    /**
     * Delete Posts
     */
    public function deletePost(Request $request){

        $id = $request->input('id');

        $userDelele = EmpPost::find($id);

        if($userDelele->delete()){
            $return['code'] = 200;
            $return['msg'] = 'Post has been Deleted.';
        }else{
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }
        return response()->json($return);

    }
}
