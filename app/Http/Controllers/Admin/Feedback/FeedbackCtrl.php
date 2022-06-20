<?php

namespace App\Http\Controllers\Admin\Feedback;

use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UsersFeedback\UsersFeedbackCtrl;
use App\Models\UsersFeedback;
use App\Models\UsersFeedbackFiles;
use App\Models\UsersFeedbackReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeedbackCtrl extends Controller
{
    /**
     * View Feedback
     */
    public function viewFeedBack()
    {
        return view('admin.manage_feedback.manage_feedback');
    }

    /**
     * Fetch Feedback
     */
    public function fetchFeedBack()
    {
        $userFeedback = UsersFeedback::select('id','user_id','date','sub','detail','status')
        ->orderBy('id','DESC')
        ->get();

        foreach($userFeedback as $row){
           $row->users->username;
        }

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
        
        $id = $request->id;
        $user = UsersFeedback::find($id);
        $userId = $user->user_id;
        $reply = $request->reply;

        // dd($reply);

        $feedreply = new UsersFeedbackReply();
        $feedreply->feed_id = $id;
        $feedreply->reply = $reply;
        $feedreply->user_id = $userId;
        $feedreply->created_at = date('Y-m-d H:i:s');
        $feedreply->source = 'admin';

        $username = $feedreply->users->username;


        if ($feedreply->save()) {
            $feedreply->username = $username;
            $return['code'] = 200;
            $return['msg'] = 'Feedback send Successfully';
            $return['data'] = $feedreply;
        } else {
            $return['code'] = 100;
            $return['msg'] = 'Feedback send Failed';
        }
        return response()->json($return);
    }


    /**
     * Fetch modal data
     */
    public function fetchModalData(Request $request)
    {
        $id = $request->id;
        $user = UsersFeedback::find($id);
        $userId = $user->user_id;
        // dd($user_id);

        // $userId = TrackSession::get()->userId();
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
     * Open Close Complained
     */
    public function addStatusFeedback(Request $request)
    {
        
        $id = $request->id;
        // $user = UsersFeedback::find($id);
        // $userId = $user->user_id;
        $status = $request->status;
        //  dd($id);

        $statData = UsersFeedback::find($id);
        
        $statData->status = $status;

        if($statData->save()){
            $return['code'] = 200;
            $return['msg'] = 'Complain Deactivate successfully';
            $return['data'] = $statData;
        }else{
            $return['code'] = 100;
            $return['msg'] = 'Complain Not Found';
        }
        return response()->json($return);
    }

        /**
     * Feedback Files
     */
    public function getFeedImages($id)
    {

        $images = UsersFeedbackFiles::select('file')
            ->where('user_feed_id', $id)
            ->get();
     
        return view('admin.manage_feedback.manage_feedback_files',['images' => $images]);
    }


    /**
     * Render Feedback Files
     */
    public function feedBackImage($folder, $img_id)
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

    public function badgesFeedback()
    {
        // return view('sssssss');
        $userFeedback = UsersFeedback::where('status', 1)->count();
        //  dd($userFeedback);
         return $userFeedback;
    }
}
