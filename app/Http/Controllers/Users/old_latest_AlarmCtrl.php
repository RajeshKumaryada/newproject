<?php

namespace App\Http\Controllers\Users;

use App\Classes\DateDiffCalculator;
use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\BackOfficeTask;
use App\Models\ContentWriterTask;
use App\Models\DesignerTask;
use App\Models\DeveloperTask;
use App\Models\HumanResourceTask;
use App\Models\SeoExecutiveTask;
use App\Models\SEOTask;
use App\Models\Users;
use App\Models\UsersAlam;
use App\Models\UsersAlarmRecord;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlarmCtrl extends Controller
{
    public function getAlarm()
    {

        $Hours = '';
        $Minutes = '';
        $Seconds = '';

        $id = TrackSession::get()->userId();
        $alarm = UsersAlam::select('user_id', 'time_in_hr', 'time_in_min')->where('user_id', $id)->orderBy('id', 'DESC')->first();



        if (!empty($alarm)) {
            $Hours = $alarm->time_in_hr;
            $Minutes = $alarm->time_in_min;
            $Seconds = 0;
            $result =  DateDiffCalculator::changeHrMinSec($Hours, $Minutes, $Seconds);
            $alarm->result = $result;
            //    dd($result);

            $users = Users::where('user_id',$id)->first();

            $post = $users->empPost->post_id;
            $complete_status_cw = '';
            $complete_status_desig = '';
            $complete_status_dev ='';
            $complete_status_hr='';
            $complete_status_seo = '';
            $complete_status_bckoffice = '';

            if($post === 1){
                $contenttask = ContentWriterTask::where('user_id', $id)->orderBy('id', 'DESC')->first();
                $complete_status_cw = $contenttask['status'];
            }

            if($post === 2){

                $Designertask = DesignerTask::where('user_id', $id)->orderBy('id', 'DESC')->first();
                $complete_status_desig = $Designertask['status'];
            }

            if($post === 3){

                $Developertask = DeveloperTask::where('user_id', $id)->orderBy('id', 'DESC')->first();
                $complete_status_dev = $Developertask['status'];

            }

            if($post === 4){

                $HumanResources = HumanResourceTask::where('user_id', $id)->orderBy('id', 'DESC')->first();
                $complete_status_hr = $HumanResources['status'];

            }

            if($post === 5){

                $SeoTask = SeoExecutiveTask::where('user_id', $id)->orderBy('id', 'DESC')->first();
                $complete_status_seo = $SeoTask['status'];
            }

            if($post === 8){

                $backofficeTask = BackOfficeTask::where('user_id', $id)->orderBy('id', 'DESC')->first();
                $complete_status_bckoffice = $backofficeTask['status'];
            }





            // if (Storage::disk('public')->exists("alarm_tone.mp3")) {
            //     $headers = array(
            //         'Content-Disposition' => 'inline',
            //     );
            //     $fileAudio = Storage::download("public/alarm_tone.mp3", null, $headers);


            // } else {
            //     $fileAudio = " ";
            // }

            $return['code'] = 200;
            $return['msg'] = 'Data Found';
            $return['data'] = $alarm;
            // $return['data'] = $fileAudio;
            $return['com_status_cw'] = $complete_status_cw;
            $return['com_status_des'] = $complete_status_desig;
            $return['com_status_dev'] = $complete_status_dev;
            $return['com_status_hr'] = $complete_status_hr;
            $return['com_status_seo'] = $complete_status_seo;
            $return['com_status_bckoffice'] = $complete_status_bckoffice;
            $return['post_id'] = $post;


            return response()->json($return);
        }
    }

    public function getAudio()
    {
        if (Storage::disk('public')->exists("alarm_tone.mp3")) {
            $headers = array(
                'Content-Disposition' => 'inline',
            );
            $file = Storage::download("public/alarm_tone.mp3", null, $headers);

            return $file;
        } else {
            return abort(404);
        }

        // $fileAudio  = Storage::disk('local')->get('alarm_tone.mp3');


        $return['code'] = 200;
        $return['msg'] = 'Finish task successfully';
        return response()->json($return);
    }



    /**
     * End Alarm
     */
    public function endAlarm(Request $request)
    {
        $id = TrackSession::get()->userId();

        // $task_id = $request->id;

        $users = Users::where('user_id',$id)->first();

        $post = $users->empPost->post_id;

        // dd($post);

        if($post == 1){
            $d = '';

            $date = date_create(date("Y-m-d H:i:s"));
            $d = date_modify($date, "-5 minutes");
            $date_n =  date_format($d, "H:i:s");
            $end_time_modify = date("Y-m-d H:i:s", strtotime($date_n));

            $contenttask = ContentWriterTask::select('id', 'start_time', 'end_time', 'task')->where('user_id', $id)->where('complete', '0')->orderBy('id', 'DESC')->first();


            $contenttask->end_time = $end_time_modify;
            $contenttask->status = 1;
            $contenttask->complete = 1;
            $count = 0;

            if ($contenttask->save()) {
                    $date =  date('Y-m-d');
                    //  $recordData = UsersAlarmRecord::whereDate('date',$date)->where('user_id',$id)->get();
                    $recordData = DB::table('users_alarm_records')
                        ->where('user_id', $id)
                        ->whereDate('date', $date)
                        ->get();

                    $date_wt_time = date('Y-m-d H:i:s');
                    if (!$recordData->isEmpty()) {
                        foreach ($recordData as $idx => $row) {
                            $id_record = $row->id;
                            //    dd($id_record);
                            $record = UsersAlarmRecord::find($id_record);

                            $countt = $record->count;
                            $record->date = $date_wt_time;
                            $record->count = $countt + 1;
                            $record->save();
                        }
                    } else {

                        $recordInsert = new  UsersAlarmRecord();
                        $recordInsert->user_id = $id;
                        $recordInsert->date = $date_wt_time;
                        $recordInsert->count = 1;

                        $recordInsert->save();
                    }

                    $return['code'] = 200;
                    $return['msg'] = 'Finish task successfully';
                    $return['data'] = $contenttask;
                    $return['difftime'] = $end_time_modify;
                }
                return response()->json($return);
         }


        If($post == 2){
            $d = '';

            $date = date_create(date("Y-m-d H:i:s"));
            $d = date_modify($date, "-5 minutes");
            $date_n =  date_format($d, "H:i:s");
            $end_time_modify = date("Y-m-d H:i:s", strtotime($date_n));

            $Designertask = DesignerTask::select('id', 'start_time', 'end_time', 'task')->where('user_id', $id)->where('complete', '0')->orderBy('id', 'DESC')->first();


            $Designertask->end_time = $end_time_modify;
            $Designertask->status = 1;
            $Designertask->complete = 1;
            $count = 0;

            if ($Designertask->save()) {
                    $date =  date('Y-m-d');
                    //  $recordData = UsersAlarmRecord::whereDate('date',$date)->where('user_id',$id)->get();
                    $recordData = DB::table('users_alarm_records')
                        ->where('user_id', $id)
                        ->whereDate('date', $date)
                        ->get();

                    $date_wt_time = date('Y-m-d H:i:s');
                    if (!$recordData->isEmpty()) {
                        foreach ($recordData as $idx => $row) {
                            $id_record = $row->id;
                            //    dd($id_record);
                            $record = UsersAlarmRecord::find($id_record);

                            $countt = $record->count;
                            $record->date = $date_wt_time;
                            $record->count = $countt + 1;
                            $record->save();
                        }
                    } else {

                        $recordInsert = new  UsersAlarmRecord();
                        $recordInsert->user_id = $id;
                        $recordInsert->date = $date_wt_time;
                        $recordInsert->count = 1;

                        $recordInsert->save();
                    }

                    $return['code'] = 200;
                    $return['msg'] = 'Finish task successfully';
                    $return['data'] = $Designertask;
                    $return['difftime'] = $end_time_modify;
                }
                return response()->json($return);
        }

        if($post == 3){
            $d = '';

            $date = date_create(date("Y-m-d H:i:s"));
            $d = date_modify($date, "-5 minutes");
            $date_n =  date_format($d, "H:i:s");
            $end_time_modify = date("Y-m-d H:i:s", strtotime($date_n));

            $Developertask = DeveloperTask::select('id', 'start_time', 'end_time', 'task')->where('user_id', $id)->where('complete', '0')->orderBy('id', 'DESC')->first();


            $Developertask->end_time = $end_time_modify;
            $Developertask->status = 1;
            $Developertask->complete = 1;
            $count = 0;

            if ($Developertask->save()) {
                    $date =  date('Y-m-d');
                    //  $recordData = UsersAlarmRecord::whereDate('date',$date)->where('user_id',$id)->get();
                    $recordData = DB::table('users_alarm_records')
                        ->where('user_id', $id)
                        ->whereDate('date', $date)
                        ->get();

                    $date_wt_time = date('Y-m-d H:i:s');
                    if (!$recordData->isEmpty()) {
                        foreach ($recordData as $idx => $row) {
                            $id_record = $row->id;
                            //    dd($id_record);
                            $record = UsersAlarmRecord::find($id_record);

                            $countt = $record->count;
                            $record->date = $date_wt_time;
                            $record->count = $countt + 1;
                            $record->save();
                        }
                    } else {

                        $recordInsert = new  UsersAlarmRecord();
                        $recordInsert->user_id = $id;
                        $recordInsert->date = $date_wt_time;
                        $recordInsert->count = 1;

                        $recordInsert->save();
                    }

                    $return['code'] = 200;
                    $return['msg'] = 'Finish task successfully';
                    $return['data'] = $Developertask;
                    $return['difftime'] = $end_time_modify;
                }
                return response()->json($return);
        }

        if($post == 4){
            $d = '';

            $date = date_create(date("Y-m-d H:i:s"));
            $d = date_modify($date, "-5 minutes");
            $date_n =  date_format($d, "H:i:s");
            $end_time_modify = date("Y-m-d H:i:s", strtotime($date_n));

            $Seotask = SeoExecutiveTask::select('id', 'start_time', 'end_time', 'task')->where('user_id', $id)->where('complete', '0')->orderBy('id', 'DESC')->first();


            $Seotask->end_time = $end_time_modify;
            $Seotask->status = 1;
            $Seotask->complete = 1;
            $count = 0;

            if ($Seotask->save()) {
                    $date =  date('Y-m-d');
                    //  $recordData = UsersAlarmRecord::whereDate('date',$date)->where('user_id',$id)->get();
                    $recordData = DB::table('users_alarm_records')
                        ->where('user_id', $id)
                        ->whereDate('date', $date)
                        ->get();

                    $date_wt_time = date('Y-m-d H:i:s');
                    if (!$recordData->isEmpty()) {
                        foreach ($recordData as $idx => $row) {
                            $id_record = $row->id;
                            //    dd($id_record);
                            $record = UsersAlarmRecord::find($id_record);

                            $countt = $record->count;
                            $record->date = $date_wt_time;
                            $record->count = $countt + 1;
                            $record->save();
                        }
                    } else {

                        $recordInsert = new  UsersAlarmRecord();
                        $recordInsert->user_id = $id;
                        $recordInsert->date = $date_wt_time;
                        $recordInsert->count = 1;

                        $recordInsert->save();
                    }

                    $return['code'] = 200;
                    $return['msg'] = 'Finish task successfully';
                    $return['data'] = $Seotask;
                    $return['difftime'] = $end_time_modify;
                }
                return response()->json($return);
        }

        if($post == 5){
            $d = '';

            $date = date_create(date("Y-m-d H:i:s"));
            $d = date_modify($date, "-5 minutes");
            $date_n =  date_format($d, "H:i:s");
            $end_time_modify = date("Y-m-d H:i:s", strtotime($date_n));

            $Hrttask = HumanResourceTask::select('id', 'start_time', 'end_time', 'task')->where('user_id', $id)->where('complete', '0')->orderBy('id', 'DESC')->first();


            $Hrttask->end_time = $end_time_modify;
            $Hrttask->status = 1;
            $Hrttask->complete = 1;
            $count = 0;

            if ($Hrttask->save()) {
                    $date =  date('Y-m-d');
                    //  $recordData = UsersAlarmRecord::whereDate('date',$date)->where('user_id',$id)->get();
                    $recordData = DB::table('users_alarm_records')
                        ->where('user_id', $id)
                        ->whereDate('date', $date)
                        ->get();

                    $date_wt_time = date('Y-m-d H:i:s');
                    if (!$recordData->isEmpty()) {
                        foreach ($recordData as $idx => $row) {
                            $id_record = $row->id;
                            //    dd($id_record);
                            $record = UsersAlarmRecord::find($id_record);

                            $countt = $record->count;
                            $record->date = $date_wt_time;
                            $record->count = $countt + 1;
                            $record->save();
                        }
                    } else {

                        $recordInsert = new  UsersAlarmRecord();
                        $recordInsert->user_id = $id;
                        $recordInsert->date = $date_wt_time;
                        $recordInsert->count = 1;

                        $recordInsert->save();
                    }

                    $return['code'] = 200;
                    $return['msg'] = 'Finish task successfully';
                    $return['data'] = $Hrttask;
                    $return['difftime'] = $end_time_modify;
                }
                return response()->json($return);
        }
    }


}
