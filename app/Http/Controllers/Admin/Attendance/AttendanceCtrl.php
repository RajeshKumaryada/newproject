<?php

namespace App\Http\Controllers\Admin\Attendance;

use App\Classes\AttendanceHoursCalculation;
use App\Classes\ContentHoursCalculation;
use App\Classes\HolidaysList;
use App\Http\Controllers\Controller;
use App\Models\BackOfficeTask;
use App\Models\ContentWriterTask;
use App\Models\DesignerTask;
use App\Models\DeveloperTask;
use App\Models\HumanResourceTask;
use App\Models\NewContentCount;
use App\Models\NewContentEdits;
use App\Models\NewContentTimestamps;
use App\Models\SeoExecutiveTask;
use App\Models\Users;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AttendanceCtrl extends Controller
{

    /**
     * View
     */
    public function viewSingleUser()
    {
        $userList = Users::where('user_id', '!=', 1)->orderBy('username', 'asc')->get();

        return view('admin.attendance.single_user', ['userList' => $userList]);
    }

    /**
     * Ajax call
     * POST method
     */
    // public function fetchSingleUser(Request $request)
    // {

    //   $validator = Validator::make(
    //     $request->all(),
    //     [
    //       'user' => 'required',
    //       'work_month' => 'required|date|before_or_equal:today'
    //     ],
    //     [
    //       'work_month.before_or_equal' => "The :attribute must be a before or current month."
    //     ]
    //   );


    //   if ($validator->fails()) {
    //     $return['code'] = 100;
    //     $return['msg'] = 'error';
    //     $return['err'] = $validator->errors();

    //     return response()->json($return);
    //   }


    //   $userId = $request->input('user');
    //   $workMonth = $request->input('work_month');

    //   // $userId = 43;
    //   // $workMonth = "2021-08";


    //   $users = Users::select('user_id', 'post', 'username')->find($userId);

    //   if (empty($users)) {
    //     $return['code'] = 101;
    //     $return['msg'] = 'Invalid user id.';

    //     return response()->json($return);
    //   }


    //   $userPost = $users->post;


    //   $month = date('m', strtotime($workMonth));
    //   $year = date('Y', strtotime($workMonth));
    //   $number_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    //   $startDate = "$workMonth-01";
    //   $endDate = "$workMonth-$number_of_days";


    //   $taskList = null;

    //   switch ($userPost) {


    //       //Content Writer
    //     case 1:
    //       $taskList = ContentWriterTask::where('user_id', $userId)
    //         ->whereDate('start_time',  '>=', $startDate)
    //         ->whereDate('start_time',  '<=', $endDate)
    //         ->where('complete', 1)
    //         ->whereNotNull('end_time')
    //         ->orderBy('start_time', 'asc')
    //         ->get();

    //       $postContent = true;

    //       break;

    //       //developer
    //     case 3:
    //       $taskList = DeveloperTask::where('user_id', $userId)
    //         ->whereDate('start_time',  '>=', $startDate)
    //         ->whereDate('start_time',  '<=', $endDate)
    //         ->where('complete', 1)
    //         ->whereNotNull('end_time')
    //         ->orderBy('start_time', 'asc')
    //         ->get();
    //       break;


    //       // designer
    //     case 2:
    //       $taskList = DesignerTask::where('user_id', $userId)
    //         ->whereDate('start_time',  '>=', $startDate)
    //         ->whereDate('start_time',  '<=', $endDate)
    //         ->where('complete', 1)
    //         ->whereNotNull('end_time')
    //         ->orderBy('start_time', 'asc')
    //         ->get();
    //       break;


    //       //seo
    //     case 4:
    //       $taskList = SeoExecutiveTask::where('user_id', $userId)
    //         ->whereDate('start_time',  '>=', $startDate)
    //         ->whereDate('start_time',  '<=', $endDate)
    //         ->where('complete', 1)
    //         ->whereNotNull('end_time')
    //         ->orderBy('start_time', 'asc')
    //         ->get();
    //       break;


    //       //human-resource
    //     case 5:
    //       $taskList = HumanResourceTask::where('user_id', $userId)
    //         ->whereDate('start_time',  '>=', $startDate)
    //         ->whereDate('start_time',  '<=', $endDate)
    //         ->where('complete', 1)
    //         ->whereNotNull('end_time')
    //         ->orderBy('start_time', 'asc')
    //         ->get();
    //       break;


    //       //back-office
    //     case 8:
    //       $taskList = BackOfficeTask::where('user_id', $userId)
    //         ->whereDate('start_time',  '>=', $startDate)
    //         ->whereDate('start_time',  '<=', $endDate)
    //         ->where('complete', 1)
    //         ->whereNotNull('end_time')
    //         ->orderBy('start_time', 'asc')
    //         ->get();
    //       break;
    //   }


    //   /**
    //    * when no data found
    //    */
    //   if (empty($taskList)) {

    //     return response()->json([]);
    //   }


    //   $holidays = new HolidaysList();
    //   $holidays =  $holidays->fetch();

    //   // $holidays = [];



    //   $fullDayLeaves = $halfDayPresent = $present = $extraWorFullDay = $extraWorHalfDay = 0;

    //   $output = [];
    //   $hoursPerDay = [];
    //   $attendanceHoursCal = new AttendanceHoursCalculation();

    //   $taskListCopy = clone $taskList;


    //   //loop for full month
    //   for ($i = 1; $i <= $number_of_days; $i++) {
    //     $totalHours = 0;
    //     $totalMinutes = 0;
    //     $totalSeconds = 0;
    //     $wordsCount = 0;
    //     $totalWorkHours = '';

    //     //formatting current date
    //     $crrDate = date('Y-m-d', strtotime("$workMonth-" . $i));


    //     //if loop date is = or > than current date
    //     //stop loop
    //     if (new DateTime($crrDate) >= (new DateTime(date("Y-m-d")))) {
    //       break;
    //     }


    //     $hoursPerDay[$i - 1] = $attendanceHoursCal->calculateForUser($taskListCopy, $crrDate);


    //     // $crrDay = $hoursPerDay[$i - 1]['day'];
    //     $crrDay = date("l", strtotime($crrDate));

    //     $totalHours = $hoursPerDay[$i - 1]['total_working_hours_arr'][0];
    //     $totalMinutes = $hoursPerDay[$i - 1]['total_working_hours_arr'][1];
    //     $totalSeconds = $hoursPerDay[$i - 1]['total_working_hours_arr'][2];
    //     $totalWorkHours = $hoursPerDay[$i - 1]['total_working_hours'];
    //     $wordsCount = $hoursPerDay[$i - 1]['wordsCount'];
    //     $actual_total_work_hours = $hoursPerDay[$i - 1]['actual_total_work_hours'];
    //     $diff_work_time = $hoursPerDay[$i - 1]['diff_work_time'];
    //     $calculated_first_last_hours = $hoursPerDay[$i - 1]['calculated_first_last_hours'];

    //     $attendance = null;

    //     //for getting work when holiday or sunday
    //     if ($crrDay == 'Sunday' || ($attendanceHoursCal->isHoliday($crrDate, $holidays))) {

    //       //holiday full work
    //       if ($totalHours >= 8) {

    //         // $attendance = "Extra Working Full Day";
    //         // $extraWorFullDay += 1;

    //         //checks for content writers
    //         if (!empty($postContent) && $wordsCount < 2000) {
    //           $attendance = "Extra Working Half-day";
    //           $extraWorHalfDay += 1;
    //         } else {
    //           $attendance = "Extra Working Full Day";
    //           $extraWorFullDay += 1;
    //           $present += 1;
    //         }
    //       }

    //       //holiday half work
    //       else if ($totalHours < 8 && $totalHours >= 4) {
    //         $attendance = "Extra Working Half-day";
    //         $extraWorHalfDay += 1;
    //       }

    //       //else holiday check
    //       else {


    //         if ($attendanceHoursCal->checkSandwichLeave($taskList, $crrDate, $holidays, $startDate, $endDate)) {
    //           $attendance = "Leave";
    //           $fullDayLeaves += 1;
    //         } else if ($crrDay == 'Sunday') {
    //           $attendance = "Sunday";
    //           $present += 1;
    //         } else {
    //           $attendance = "Holiday";
    //           $present += 1;
    //         }
    //       }
    //     }

    //     //check normal day full work
    //     else {
    //       if ($totalHours >= 8) {

    //         // $attendance = "Full day";
    //         // $present += 1;

    //         //checks for content writers
    //         if (!empty($postContent) && $wordsCount < 2000) {
    //           $attendance = "Half-day";
    //           $halfDayPresent += 1;
    //         } else {
    //           $attendance = "Full day";
    //           $present += 1;
    //         }
    //       } else if ($totalHours < 8 && $totalHours >= 4) {
    //         if ($totalHours == 7 && $totalMinutes >= 45) {
    //           $attendance = "Full day";
    //           $present += 1;
    //         } else {
    //           $attendance = "Half-day";
    //           $halfDayPresent += 1;
    //         }
    //       } else {
    //         $attendance = "Leave";
    //         $fullDayLeaves += 1;
    //         // if ($thisDay == 6) {
    //         //   $sat_leave = 1;
    //         // }
    //       }
    //     }


    //     $output[] = array(
    //       "date" => $crrDate,
    //       "total_hours" => $totalHours,
    //       "toal_minutes" => $totalMinutes,
    //       "total_seconds" => $totalSeconds,
    //       'total_work_hours' => $totalWorkHours,
    //       'actual_total_work_hours' => $actual_total_work_hours,
    //       "attendance" => $attendance,
    //       "day" => $crrDay,
    //       "word_count" => $wordsCount,
    //       'diff_work_time' => $diff_work_time,
    //       'calculated_first_last_hours' => $calculated_first_last_hours
    //     );


    //     //end for loop
    //   }

    //   $return['code'] = 200;
    //   $return['msg'] = 'Data found.';
    //   $return['post'] = $userPost;
    //   $return['data'] = $output;
    //   $return['leaves'] = [
    //     'days_in_month' => $number_of_days,
    //     'fullDayLeaves' => $fullDayLeaves,
    //     'halfDayPresent' => $halfDayPresent,
    //     'present' => $present,
    //     'extraWorFullDay' => $extraWorFullDay,
    //     'extraWorHalfDay' => $extraWorHalfDay
    //   ];
    //   $return['month_name'] = date('F, Y', strtotime($workMonth));
    //   $return['user_name'] = $users->username;

    //   return response()->json($return);
    // }

    public function fetchSingleUser(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'user' => 'required',
                'work_month' => 'required|date|before_or_equal:today'
            ],
            [
                'work_month.before_or_equal' => "The :attribute must be a before or current month."
            ]
        );


        if ($validator->fails()) {
            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }


        $userId = $request->input('user');
        $workMonth = $request->input('work_month');

        // $userId = 43;
        // $workMonth = "2021-08";


        $users = Users::select('user_id', 'post', 'username')->find($userId);

        if (empty($users)) {
            $return['code'] = 101;
            $return['msg'] = 'Invalid user id.';

            return response()->json($return);
        }


        $userPost = $users->post;


        $month = date('m', strtotime($workMonth));
        $year = date('Y', strtotime($workMonth));
        $number_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $startDate = "$workMonth-01";
        $endDate = "$workMonth-$number_of_days";


        $taskList = null;

        switch ($userPost) {


                //Content Writer
            case 1:
               

                $taskList = DB::table('new_content_timestamps')
                    ->select('new_content_timestamps.id', 'new_content_timestamps.start_time', 'new_content_timestamps.end_time', 'new_content_count.date', 'new_content_count.user_id', 'new_content_count.count')
                    ->leftJoin('new_content_edits', 'new_content_edits.id', '=', 'new_content_timestamps.new_content_edits_id')
                    ->leftJoin('new_content_count', 'new_content_count.content_id', '=', 'new_content_edits.new_content_id')
                    ->where('new_content_count.user_id', $userId)
                    ->whereDate('new_content_timestamps.start_time',  '>=', $startDate)
                    ->whereDate('new_content_timestamps.start_time',  '<=', $endDate)
                    ->orderBy('new_content_timestamps.start_time', 'ASC')
                    ->get();

                $tempList = [];

                foreach ($taskList as $key => $row) {
                    if (empty($tempList[$row->id])) {
                        $tempList[$row->id] = $row;
                    }else{
                        unset($taskList[$key]);
                    }
                }

                unset($tempList);

                $postContent = true;

                break;

                //developer
            case 3:
                $taskList = DeveloperTask::where('user_id', $userId)
                    ->whereDate('start_time',  '>=', $startDate)
                    ->whereDate('start_time',  '<=', $endDate)
                    ->where('complete', 1)
                    ->whereNotNull('end_time')
                    ->orderBy('start_time', 'asc')
                    ->get();
                break;


                // designer
            case 2:
                $taskList = DesignerTask::where('user_id', $userId)
                    ->whereDate('start_time',  '>=', $startDate)
                    ->whereDate('start_time',  '<=', $endDate)
                    ->where('complete', 1)
                    ->whereNotNull('end_time')
                    ->orderBy('start_time', 'asc')
                    ->get();
                break;


                //seo
            case 4:
                $taskList = SeoExecutiveTask::where('user_id', $userId)
                    ->whereDate('start_time',  '>=', $startDate)
                    ->whereDate('start_time',  '<=', $endDate)
                    ->where('complete', 1)
                    ->whereNotNull('end_time')
                    ->orderBy('start_time', 'asc')
                    ->get();
                break;


                //human-resource
            case 5:
                $taskList = HumanResourceTask::where('user_id', $userId)
                    ->whereDate('start_time',  '>=', $startDate)
                    ->whereDate('start_time',  '<=', $endDate)
                    ->where('complete', 1)
                    ->whereNotNull('end_time')
                    ->orderBy('start_time', 'asc')
                    ->get();
                break;


                //back-office
            case 8:
                $taskList = BackOfficeTask::where('user_id', $userId)
                    ->whereDate('start_time',  '>=', $startDate)
                    ->whereDate('start_time',  '<=', $endDate)
                    ->where('complete', 1)
                    ->whereNotNull('end_time')
                    ->orderBy('start_time', 'asc')
                    ->get();
                break;
        }


        /**
         * when no data found
         */
        if (empty($taskList)) {

            return response()->json([]);
        }


        $holidays = new HolidaysList();
        $holidays =  $holidays->fetch();

        // $holidays = [];



        $fullDayLeaves = $halfDayPresent = $present = $extraWorFullDay = $extraWorHalfDay = 0;

        $output = [];
        $hoursPerDay = [];
        $attendanceHoursCal = new AttendanceHoursCalculation();

        $taskListCopy = clone $taskList;


        //loop for full month
        for ($i = 1; $i <= $number_of_days; $i++) {
            $totalHours = 0;
            $totalMinutes = 0;
            $totalSeconds = 0;
            $wordsCount = 0;
            $totalWorkHours = '';

            //formatting current date
            $crrDate = date('Y-m-d', strtotime("$workMonth-" . $i));


            //if loop date is = or > than current date
            //stop loop
            if (new DateTime($crrDate) >= (new DateTime(date("Y-m-d")))) {
                break;
            }


            $hoursPerDay[$i - 1] = $attendanceHoursCal->calculateForUser($taskListCopy, $crrDate);
           


            // $crrDay = $hoursPerDay[$i - 1]['day'];
            $crrDay = date("l", strtotime($crrDate));

            $totalHours = $hoursPerDay[$i - 1]['total_working_hours_arr'][0];
            $totalMinutes = $hoursPerDay[$i - 1]['total_working_hours_arr'][1];
            $totalSeconds = $hoursPerDay[$i - 1]['total_working_hours_arr'][2];
            $totalWorkHours = $hoursPerDay[$i - 1]['total_working_hours'];
            $wordsCount = $hoursPerDay[$i - 1]['wordsCount'];
            $actual_total_work_hours = $hoursPerDay[$i - 1]['actual_total_work_hours'];
            $diff_work_time = $hoursPerDay[$i - 1]['diff_work_time'];
            $calculated_first_last_hours = $hoursPerDay[$i - 1]['calculated_first_last_hours'];

            $attendance = null; 

            //for getting work when holiday or sunday
            if ($crrDay == 'Sunday' || ($attendanceHoursCal->isHoliday($crrDate, $holidays))) {

                //holiday full work
                if ($totalHours >= 8) {

                    // $attendance = "Extra Working Full Day";
                    // $extraWorFullDay += 1;

                    //checks for content writers
                    if (!empty($postContent) && $wordsCount < 3000) {
                        $attendance = "Extra Working Half-day";
                        $extraWorHalfDay += 1;
                    } else {
                        $attendance = "Extra Working Full Day";
                        $extraWorFullDay += 1;
                        $present += 1;
                    }
                }

                //holiday half work
                else if ($totalHours < 8 && $totalHours >= 4) {
                    $attendance = "Extra Working Half-day";
                    $extraWorHalfDay += 1;
                }

                //else holiday check
                else {

                    if ($attendanceHoursCal->checkSandwichLeave($taskList, $crrDate, $holidays, $startDate, $endDate)) {
                        $attendance = "Leave";
                        $fullDayLeaves += 1;
                    } else if ($crrDay == 'Sunday') {
                        $attendance = "Sunday";
                        $present += 1;
                    } else {
                        $attendance = "Holiday";
                        $present += 1;
                    }
                }
            }

            //check normal day full work
            else {
                if ($totalHours >= 8) {

                    // $attendance = "Full day";
                    // $present += 1;

                    //checks for content writers
                    if (!empty($postContent) && $wordsCount < 3000) {
                        $attendance = "Half-day";
                        $halfDayPresent += 1;
                    } else {
                        $attendance = "Full day";
                        $present += 1;
                    }
                } else if ($totalHours < 8 && $totalHours >= 4) {
                    if ($totalHours == 7 && $totalMinutes >= 45) {
                        $attendance = "Full day";
                        $present += 1;
                    } else {
                        $attendance = "Half-day";
                        $halfDayPresent += 1;
                    }
                } else {
                    $attendance = "Leave";
                    $fullDayLeaves += 1;
                    // if ($thisDay == 6) {
                    //   $sat_leave = 1;
                    // }
                }
            }


            $output[] = array(
                "date" => $crrDate,
                "total_hours" => $totalHours,
                "toal_minutes" => $totalMinutes,
                "total_seconds" => $totalSeconds,
                'total_work_hours' => $totalWorkHours,
                'actual_total_work_hours' => $actual_total_work_hours,
                "attendance" => $attendance,
                "day" => $crrDay,
                "word_count" => $wordsCount,
                'diff_work_time' => $diff_work_time,
                'calculated_first_last_hours' => $calculated_first_last_hours
            );


            //end for loop
        }

        $return['code'] = 200;
        $return['msg'] = 'Data found.';
        $return['post'] = $userPost;
        $return['data'] = $output;
        $return['leaves'] = [
            'days_in_month' => $number_of_days,
            'fullDayLeaves' => $fullDayLeaves,
            'halfDayPresent' => $halfDayPresent,
            'present' => $present,
            'extraWorFullDay' => $extraWorFullDay,
            'extraWorHalfDay' => $extraWorHalfDay
        ];
        $return['month_name'] = date('F, Y', strtotime($workMonth));
        $return['user_name'] = $users->username;

        return response()->json($return);
    }
}
