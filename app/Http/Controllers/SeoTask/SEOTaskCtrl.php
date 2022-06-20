<?php

namespace App\Http\Controllers\SeoTask;

use App\Http\Controllers\Controller;
use App\Models\SEOTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SEOTaskCtrl extends Controller
{

    /**
     * Add SEO Data Form 
     */
    public function addSeoForm()
    {
        
        // return "index";
        // $userInfo = SEOTask::where('user_id', $userId)->first();

        return view('admin.seo_task.task_seo');
    }

    public function addNewTask(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                
                'task' => "required|max:250",
                'exclude_from_url_check' => "required",
                
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }


        $option = new SEOTask();
        $option->task = $request->input('task');
        $option->exclude_from_url_check = $request->input('exclude_from_url_check');


        if (empty($option)) {

            $return['code'] = 101;
            $return['msg'] = 'Task not found!';

            return response()->json($return);
        }


        if ($option->save()) {

            $return['code'] = 200;
            $return['msg'] = 'Task Inserted.';
        } else {

            $return['code'] = 101;
            $return['msg'] = 'Task not found!';
        }

        return response()->json($return);
    }


    public function fetchTaskList()
    {
        $empDep = SEOTask::orderBy('task', 'ASC')->get();

        $return['code'] = 200;
        $return['msg'] = 'Data found.';
        $return['data'] = $empDep;

        return response()->json($return);
    }


    // public function getSingleTaskId(Request $request)
    // {

    //     $validator = Validator::make(
    //         $request->all(),
    //         [
    //             'id' => "required|max:150",
    //         ]
    //     );

    //     if ($validator->fails()) {

    //         $return['code'] = 100;
    //         $return['msg'] = 'error';
    //         $return['err'] = $validator->errors();

    //         return response()->json($return);
    //     }

    //     $id = $request->id;

    //     $user = SEOTask::select('id', 'task','exclude_from_url_check')->find($id);

    //     $return['code'] = 200;
    //     $return['msg'] = 'data found';
    //     $return['data'] = $user;

    //     return response()->json($return);
    // }

    public function updateTask(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'update_task' => "required|unique:emp_department,dep_name|max:150",
                'update_exclude_from_url_check' => "required"
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $id = $request->update_id;

        $users = SEOTask::find($id);


        if (empty($users)) {
            
            $return['code'] = 101;
            $return['msg'] = 'Task not found!';

            return response()->json($return);
        }

        $users->task = $request->input('update_task');
        $users->exclude_from_url_check = $request->input('update_exclude_from_url_check');

        if ($users->save()) {
            $return['code'] = 200;
            $return['msg'] = 'Task has been Updated.';
        } else {
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }

        return response()->json($return);
    }

    /**
     * Delete Seo Task
     */
    public function deleteTask(Request $request){

        $id = $request->input('id');
        $userDelele = SEOTask::find($id);

        if($userDelele->delete()){
            $return['code'] = 200;
            $return['msg'] = 'Task has been Deleted.';
        }else{
            $return['code'] = 101;
            $return['msg'] = 'Error: Please contact administrator.';
        }
        return response()->json($return);

    }
}
