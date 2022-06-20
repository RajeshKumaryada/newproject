<?php

namespace App\Http\Controllers\UsersFeedback;

use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\UsersFeedback;
use App\Models\UsersFeedbackFiles;
use App\Models\UsersFeedbackReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UsersFeedbackCtrl extends Controller
{
    public function viewFeedbackForm()
    {
        $userId = TrackSession::get()->userId();

        // $adminReply = UsersFeedbackReply::select('created_at','reply')->where('source','admin')->where('user_id',$userId)->get();
        // $usersReply = UsersFeedbackReply::select('created_at','reply')->where('user_id',$userId)->where('source','user')->get();

        return view('users_feedback.users_feedback');
    }

    /**
     * Submit Feedback
     */
    public function addFeedbackForm(Request $request)
    {

        $userId = TrackSession::get()->userId();

        // dd($userId);

        $validator = Validator::make(
            $request->all(),
            [
                'subject'    => "required|max:150",
                'detail' => "required|max:250",
                'file'  => ""

            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $subject = $request->subject;
        $detail = $request->detail;
        $files = $request->file('file');
        if(!empty($files)){
            $image = [];
            foreach ($files as $file) {
    
                $image[] =  $file->storePublicly('feedback_files', 'public');
            }

        }
       

        // dd($files);


        // foreach($files as $idx => $value){
        //     $image[$idx]= $value;
        // }

        $userFeed = new UsersFeedback();
        $userFeed->user_id = $userId;
        $userFeed->date = date('Y-m-d H:i:s');
        $userFeed->sub = $subject;
        $userFeed->detail = $detail;
        $userFeed->status = 1;


        if ($userFeed->save()) {

            $id = $userFeed->id;

            $dataInsert = null;

            if(!empty($image)){
                foreach ($image as $img) {
                    $dataInsert[] = [
                        'user_feed_id' => $userFeed->id,
                        'file' => $img,
                    ];
                }
            }else{
                $dataInsert[] = [
                    'user_feed_id' => $userFeed->id,
                    'file' => '' ,
                ];
            }

          

            $userFeedfiles = UsersFeedbackFiles::insert($dataInsert);

            $return['code'] = 200;
            $return['msg'] = 'Feedback Insert Successfully';
            $return['data'] = $userFeed;
        } else {
            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = 'Feedback Insert Failed ';
        }

        return response()->json($return);
    }

    /**
     * Fetch Feedback data
     */
    public function fetchFeedbackData()
    {
        $userId = TrackSession::get()->userId();
        $userFeedback = UsersFeedback::where('user_id',$userId)->get();
        $return['code'] = 200;
        $return['msg'] = 'Data Found';
        $return['data'] = $userFeedback;
        return response()->json($return);
    }


    /**
     *  Reply Submit
     */
    public function addReplyFeedback(Request $request)
    {
        $userId = TrackSession::get()->userId();
        $id = $request->id;
        $reply = $request->reply;

        // dd($reply);

        $feedreply = new UsersFeedbackReply();
        $feedreply->feed_id = $id;
        $feedreply->reply = $reply;
        $feedreply->user_id = $userId;
        $feedreply->created_at = date('Y-m-d H:i:s');
        $feedreply->source = 'user';

        $username = $feedreply->users->username;


        if ($feedreply->save()) {
            $feedreply->username = $username;
            $return['code'] = 200;
            $return['msg'] = 'Feedback Reply Inserted Successfully';
            $return['data'] = $feedreply;
        } else {
            $return['code'] = 100;
            $return['msg'] = 'Feedback Reply Inserted Failed';
        }
        return response()->json($return);
    }
    /**
     * Fetch Modal data
     */
    public function fetchModalData(Request $request)
    {
        $id = $request->id;

        $userId = TrackSession::get()->userId();
        // $dataFeedback = UsersFeedback::find($id);
        // dd($dataFeedback);
        $dataModal = UsersFeedbackReply::where('user_id', $userId)->where('feed_id', $id)->get();

        foreach ($dataModal as $row) {
            $row->users->username;
        }
        // dd($dataModal);

        if ($dataModal) {
            $return['code'] = 200;
            $return['msg'] = 'Data Found';
            $return['data'] = $dataModal;
        } else {
            $return['code'] = 100;
            $return['msg'] = 'Data Not Found';
        }
        return response()->json($return);
    }


    /**
     * Feedback Files
     */
    public function getFeedBackImages($id)
    {

        $imagesUser = UsersFeedbackFiles::select('file')
            ->where('user_feed_id', $id)
            ->get();
        // dd($imagesUser);
        return view('users_feedback.users_feedback_files', ['imagesUser' => $imagesUser]);
    }


    /**
     * Render Feedback Files
     */
    public function renderFeedBackImage($folder, $img_id)
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
}
