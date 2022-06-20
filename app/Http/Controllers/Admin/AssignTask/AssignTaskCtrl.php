<?php

namespace App\Http\Controllers\Admin\AssignTask;

use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\AssignTask;
use App\Models\AssignTaskImage;
use App\Models\EmpPost;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AssignTaskCtrl extends Controller
{
    /**
     * View Form
     */

    public function getAssignForm()
    {
        $empdes = EmpPost::where('post_name', 'Designer')->first();
        $empdev = EmpPost::where('post_name', 'Developer')->first();

        //  dd($empdes->post_id);
        $users = Users::where('username', '<>', 'admin')
            ->where('post', $empdes->post_id)
            ->orWhere('post', $empdev->post_id)
            ->orderBy('post', 'ASC')
            ->orderBy('username', 'ASC')
            ->get();

        return view('admin.assign_task.task_assign', ['users' => $users]);
    }


      /**
     * Add Assign Form
     */
    public function addAssignForm(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_list' => "required",
                'title' => "required",
                'des' => "required",
                'files' => "",

            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();
            return response()->json($return);
        }

        $user_list = $request->user_list;
        $title = $request->title;
        $des = $request->des;
        $files = $request->file('files');

        
        $image = [];
        if(!empty($files)){
            foreach ($files as $file) {

                $image[] =  $file->storePublicly('assign_task_files', 'public');
            }
    
        }
       

        $assignTask = new AssignTask();

        $assignTask->user_id = implode(',', $user_list);

        $assignTask->created_at = date('Y-m-d h:i:s');

        $assignTask->title = $title;

        $assignTask->des = $des;

        // $assignTask->remark = '';

        $assignTask->status = 0;

        if ($assignTask->save()) {

            if(!empty($image)){
                $dataInsert = null;

                foreach ($image as $img) {
                    $dataInsert[] = [
                        'assign_id' => $assignTask->id,
                        'images' => $img,
                        'source' => 'admin',
                    ];
                }
    
                AssignTaskImage::insert($dataInsert);
            }
           
            $return['code'] = 200;
            $return['msg'] = "Assign Task Successfully";
            $return['data'] = $assignTask;
        } else {
            $return['code'] = 101;
            $return['msg'] = "Assign Not Task Successfully";
        }

        return response()->json($return);
    }



    /**
     * Fetch Assign Form
     */
    public function fetchAssignForm()
    {
        $list = AssignTask::orderBy('id', 'DESC')
            ->get();


        foreach ($list as $row) {

            $user_id = explode(',', $row->user_id);

            $users = Users::select('username')
                ->whereIn('user_id', $user_id)
                ->get();

            $row->usernames = $users;
        }

        $return['code'] = 200;
        $return['msg'] = "Data Found";
        $return['data'] = $list;


        return response()->json($return);
    }


    /**
     * Get Assign Images by Id
     */
    public function getAssignImages($user_id, $id)
    {
        // $user_id = request()->segment(5);
        //   dd($user_id);
        $users = Users::select('username')
            ->where('user_id',  $user_id)
            ->first();

        // dd($users);

        $imagesAdmin = AssignTaskImage::select('images')
            ->where('assign_id', $id)
            ->where('source', 'admin')
            ->get();

        $imagesUser = AssignTaskImage::select('images')
            ->where('assign_id', $id)
            ->where('source', 'user')
            ->get();

        return view('admin.assign_task.task_assign_images', ['imagesAdmin' => $imagesAdmin, 'imagesUser' => $imagesUser, 'users' => $users]);
    }


    /**
     * Render Task Assign Images
     */
    public function renderTaskAssignImage($folder, $img_id)
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
    public function badgesAssignTask()
    {

        $userAssignTask = AssignTask::where('status', 0)->count();

        return $userAssignTask;
    }
}
