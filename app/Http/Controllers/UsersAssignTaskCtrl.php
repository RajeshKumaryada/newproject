<?php

namespace App\Http\Controllers;

use App\Classes\TrackSession;
use App\Models\AssignTask;
use App\Models\AssignTaskImage;
use App\Models\AssignTaskStatus;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UsersAssignTaskCtrl extends Controller
{


    public function viewUserTask()
    {
        $userId = TrackSession::get()->userId;

        // $taskid = TrackSession::get()->getAssignId();

        $data = AssignTask::where('user_id', $userId)
        ->orderBy('id','DESC')
        ->get();
       
    
        //   dd($data);
        // $dataImg = AssignTaskImage::where('assign_id', $data->id)->get();
        // dd($dataImg);


        return view('users_assign_task.assign_users_task', ['data' => $data]);
    }

    /**
     * 
     */
    public function fetchUserTask()
    {
        $userId = TrackSession::get()->userId;

        $list = AssignTask::where('user_id', $userId)->orderBy('id','DESC')->get();

        //  dd($list);

        foreach ($list as $row) {

            $image_id = $row->id;
            //dd($image_id);
            $users = AssignTaskImage::select('images')
                ->where('assign_id', $image_id)
                ->get();

            $row->images = $users;
        }

        $return['code'] = 200;
        $return['msg'] = "Data Found";
        $return['data'] = $list;


        return response()->json($return);
    }


    /**
     * Get Assign Images by Id
     */
    public function getUserAssignImages($id)
    {
        // $user_id = request()->segment(5);
        // // dd($user_id);
        // $users = Users::select('username')
        // ->where('user_id',  $user_id)
        // ->first();
        
        $imagesAdmin = AssignTaskImage::select('images')->where('assign_id', $id)->where('source', 'admin')->get();
        $imagesUser = AssignTaskImage::select('images')->where('assign_id', $id)->where('source', 'user')->get();
        return view('users_assign_task.assign_users_images', ['imagesAdmin' => $imagesAdmin, 'imagesUser' => $imagesUser]);
    }


    /**
     * Render Task Assign Images
     */
    public function renderUserTaskAssignImage($folder, $img_id)
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
     * Status in progress
     */
    public function statusInProgress(Request $request)
    {
        $Id = $request->id;
        $status = $request->status;
        // dd($status);
        $assignTask = AssignTask::find($Id);

        $assignTask->status = $status;

        if ($assignTask->save()) {
            $return['code'] = 200;
            $return['msg'] = "Update Status Process";
        } else {
            $return['code'] = 101;
            $return['msg'] = "Update Status failed";
        }
        return response()->json($return);
    }

    public function submitRemark(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'id' => "required|numeric",
                'remark' => "required",
                'files' => "",

            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();
            return response()->json($return);
        }


        $Id = $request->id;
        // $status = $request->status;
        $remark = $request->remark;

        $files = $request->file('files');

        if(!empty($files)){
            
            foreach ($files as $file) {

                $image[] =  $file->storePublicly('assign_task_files', 'public');
            }
        }

        //  dd($files);
        $assignTask = AssignTask::find($Id);

        $assignTask->status = '2';
        $assignTask->remark = $remark;


        if ($assignTask->save()) {

            $dataInsert = null;

            if(!empty($image)){
                foreach ($image as $img) {
                    $dataInsert[] = [
                        'assign_id' => $assignTask->id,
                        'images' => $img,
                        'source' => 'user',
                    ];
    
                }
            }else{
                $dataInsert[] = [
                    'assign_id' => $assignTask->id,
                    'images' => " ",
                    'source' => 'user',
                ];
            }
            

            AssignTaskImage::insert($dataInsert);

            $return['code'] = 200;
            $return['msg'] = "Update Task Successfully";
        } else {
            $return['code'] = 101;
            $return['msg'] = "Update Task failed";
        }
        return response()->json($return);
    }

    public function assignNotify(Request $request)
    {
        $data = [];
         
        $taskid = explode(',',$request->id);

        if(!empty($taskid)){
            
        $user_id = $request->user_id;
        foreach($taskid as $idx => $value){

            $id_s[$idx] = $value;

            $data = [

                'user_id'=> $user_id,
                'last_id' => $id_s[$idx],
            
        ];

        $row1 = $data['last_id'];

        if (AssignTaskStatus::insert($data)) {

                $assignTask = AssignTask::find($row1);

                $assignTask->status = 1;
                $assignTask->save();
    
            $return['code'] = 200;
            $return['msg'] = "Update Task Status";
        } else {
            $return['code'] = 101;
            $return['msg'] = "Update Task Status failed";
        }
        
        }
       
        return response()->json($return);
        }
      

    }


    public function assignBadges(){
        $userId = TrackSession::get()->userId;
         $userAssignTask = AssignTask::where('status',0)->where('user_id',$userId)->count();
        
        return $userAssignTask;
    }
}
