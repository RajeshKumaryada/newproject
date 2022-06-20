<?php

namespace App\Http\Controllers\ManageOptions;

use App\Http\Controllers\Controller;
use App\Models\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManageOptionsCtrl extends Controller
{

  
  
    /**
     * Fetch Id data
     */
    public function fetchIdAData()
    {
        $data = Options::select('opt_value')->where('opt_key', 'notice_board_msg')->first(); //->find(2);

        return view('admin.manage_options.options_manage_notification', compact('data'));
    }




    /**
     * Insert Notification message
     */
    public function addNewMessage(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'opt_value' => "required|max:500",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $option = Options::where('opt_key', 'notice_board_msg')->first();

        if (empty($option)) {

            $return['code'] = 101;
            $return['msg'] = 'Message not found!';

            return response()->json($return);
        }

        $option->opt_value = $request->input('opt_value');

        if ($option->save()) {

            $return['code'] = 200;
            $return['msg'] = 'Message Updated.';
        } else {

            $return['code'] = 101;
            $return['msg'] = 'Message not found!';
        }

        return response()->json($return);
    }



    /**
     * Fetch Time
     */
    public function fetchWorkTimeIdAData(){
        $data = Options::select('opt_value')->where('opt_key', 'min_work_time_in_day')->first(); //->find(2);
      // dd($data);
        return view('admin.manage_options.options_manage_worktime', compact('data'));

    }



    /**
     * Insert Work Timing
     * 
     */
    public function addNewWorkTime(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'opt_value' => "required|max:500",
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }


        $option = Options::where('opt_key', 'min_work_time_in_day')->first();

        if (empty($option)) {

            $return['code'] = 101;
            $return['msg'] = 'Time not found!';

            return response()->json($return);
        }

        $option->opt_value = date('H:i:s', strtotime($request->input('opt_value')));


        if ($option->save()) {

            $return['code'] = 200;
            $return['msg'] = 'Time Updated.';
        } else {

            $return['code'] = 101;
            $return['msg'] = 'Time not found!';
        }

        return response()->json($return);
    }
}
