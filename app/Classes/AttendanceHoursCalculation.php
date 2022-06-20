<?php

namespace App\Classes;

use App\Models\NewContentCount;
use App\Models\Options;
use DateTime;
use Illuminate\Support\Facades\DB;

class AttendanceHoursCalculation
{

  private $minWorkingHours;


  public function __construct()
  {
    $this->minWorkingHours = $this->minWorkTime();
  }


  /**
   * getting working time from databse
   */
  private function minWorkTime()
  {
    $time = Options::where('opt_key', 'min_work_time_in_day')->first();

    return $time->opt_value;
  }


  /**
   * This function for User end
   * Calculate Working hours for today working user
   */
  // public function calculateForUser($taskList, $crrDate = null)
  // {
  //   $dateDiffObj = new DateDiffCalculator();

  //   $tempData = [];

  //   $totHours = 0;
  //   $totMinutes = 0;
  //   $totSeconds = 0;
  //   $wordsCount = 0;

  //   $isMinTimeWorkDone = true;
  //   $diff_work_time = '';
  //   $actual_total_work_hours = '';
  //   $calculated_first_last_hours = '';



  //   /**
  //    * stroing required date rows into $taskListTemp
  //    */
  //   $taskListTemp = [];
  //   foreach ($taskList as $key => $row) {

  //     if (strtotime($crrDate) === strtotime(date('Y-m-d', strtotime($row->start_time)))) {
  //       $taskListTemp[] = $row;
  //       unset($taskList[$key]);
  //     }
  //   }



  //   if (!empty($taskListTemp)) {

  //     //getting time of first start task
  //     $first = reset($taskListTemp);
  //     $startTime = $first->start_time;

  //     //getting end time of last start task
  //     $last = end($taskListTemp);
  //     $endTime = $last->end_time;


  //     //calculating total time duration
  //     //between start and end task time
  //     if (!empty($endTime)) {
  //       $dateDiffObj->calculate($startTime, $endTime);
  //       $tempHours = $dateDiffObj->getHr();
  //       $tempMinuts = $dateDiffObj->getMin();
  //       $tempSeconds = $dateDiffObj->getSec();

  //       $time_first_last_task = "$crrDate $tempHours:$tempMinuts:$tempSeconds";

  //       $calculated_first_last_hours = DateDiffCalculator::getToTimeFormat($tempHours, $tempMinuts, $tempSeconds);
  //     }


  //     //make current date for value getting from DB
  //     $minWorkingHours = $crrDate . " " . $this->minWorkingHours;


  //     // $remainTimeDiff = 0;

  //     if (strtotime($minWorkingHours) > strtotime($time_first_last_task)) {
  //       $isMinTimeWorkDone = false;

  //       // echo $timeDiff = strtotime($minWorkingHours) - strtotime($time_first_last_task);

  //       //when min duration is not completed, calculate how much
  //       $dateDiffObj->calculate($minWorkingHours, $time_first_last_task);
  //       $tempHours = $dateDiffObj->getHr();
  //       $tempMinuts = $dateDiffObj->getMin();
  //       $tempSeconds = $dateDiffObj->getSec();
  //       $dateDiffObj->calHrMinSec($tempHours, $tempMinuts, $tempSeconds);

  //       $diff_work_time = DateDiffCalculator::getToTimeFormat($tempHours, $tempMinuts, $tempSeconds);
  //     }
  //   }



  //   /**
  //    * calculating total time in a day
  //    */
  //   foreach ($taskListTemp as $row) {

  //     if (!empty($row->end_time)) {
  //       $dateDiffObj->calculate($row->start_time, $row->end_time);
  //       $totHours += $dateDiffObj->getHr();
  //       $totMinutes += $dateDiffObj->getMin();
  //       $totSeconds += $dateDiffObj->getSec();

  //       if (isset($row->word_count)) {
  //         $wordsCount += $row->word_count;
  //       }
  //     } else {
  //       continue;
  //     }

  //     //calculate total working hours
  //     DateDiffCalculator::calHrMinSec($totHours, $totMinutes, $totSeconds);
  //   }

  //   $actual_total_work_hours = DateDiffCalculator::getToTimeFormat($totHours, $totMinutes, $totSeconds);


  //   $total_working_hours = DateDiffCalculator::getToTimeFormat($totHours, $totMinutes, $totSeconds);
  //   $total_working_hours_arr = [$totHours, $totMinutes, $totSeconds];



  //   //when less time found
  //   //7.75 is min time to consider full day
  //   if (!$isMinTimeWorkDone && $totHours >= 7.75) {

  //     $totalWorkMinutes = DateDiffCalculator::intoMinutes($totHours, $totMinutes, $totSeconds);

  //     $remainWorkMinutes = DateDiffCalculator::intoMinutes($tempHours, $tempMinuts, $tempSeconds);

  //     $afterLessTime = $totalWorkMinutes - $remainWorkMinutes;

  //     $balanceTime = DateDiffCalculator::intoHrIsSec($afterLessTime);

  //     $total_working_hours = DateDiffCalculator::getToTimeFormat($balanceTime[0], $balanceTime[1], $balanceTime[2]);

  //     $total_working_hours_arr = [$balanceTime[0], $balanceTime[1], $balanceTime[2]];
  //   }



  //   $tempData = [
  //     'total_working_hours' => $total_working_hours,
  //     'total_working_hours_arr' => $total_working_hours_arr,
  //     'actual_total_work_hours' => $actual_total_work_hours,
  //     'wordsCount' => $wordsCount,
  //     'isMinTimeWorkDone' =>  $isMinTimeWorkDone,
  //     'diff_work_time' => $diff_work_time,
  //     'calculated_first_last_hours' => $calculated_first_last_hours,
  //   ];



  //   return $tempData;
  // }

  /**
   * This function for User End
   *  Today Work of word count from New_Content_Count table and interrelated,
   */
  public function calculateForUser($taskList, $crrDate = null)
  {
    $dateDiffObj = new DateDiffCalculator();

    $tempData = [];

    $totHours = 0;
    $totMinutes = 0;
    $totSeconds = 0;
    $wordsCount = 0;

    $isMinTimeWorkDone = true;
    $diff_work_time = '';
    $actual_total_work_hours = '';
    $calculated_first_last_hours = '';

   // dd($taskList);

    /**
     * stroing required date rows into $taskListTemp
     */
    $taskListTemp = [];
    foreach ($taskList as $key => $row) {

      if (strtotime($crrDate) === strtotime(date('Y-m-d', strtotime($row->start_time)))) {
        $taskListTemp[] = $row;
        unset($taskList[$key]);
      }
    }

    // dd($row);


    if (!empty($taskListTemp)) {

      //getting time of first start task
      $first = reset($taskListTemp);
      $startTime = $first->start_time;

      //getting end time of last start task
      $last = end($taskListTemp);
      $endTime = $last->end_time;


      //calculating total time duration
      //between start and end task time
      if (!empty($endTime)) {
        $dateDiffObj->calculate($startTime, $endTime);
        $tempHours = $dateDiffObj->getHr();
        $tempMinuts = $dateDiffObj->getMin();
        $tempSeconds = $dateDiffObj->getSec();

        $time_first_last_task = "$crrDate $tempHours:$tempMinuts:$tempSeconds";

        $calculated_first_last_hours = DateDiffCalculator::getToTimeFormat($tempHours, $tempMinuts, $tempSeconds);
      }


      //make current date for value getting from DB
      $minWorkingHours = $crrDate . " " . $this->minWorkingHours;


      // $remainTimeDiff = 0;

      if (strtotime($minWorkingHours) > strtotime($time_first_last_task)) {
        $isMinTimeWorkDone = false;

        // echo $timeDiff = strtotime($minWorkingHours) - strtotime($time_first_last_task);

        //when min duration is not completed, calculate how much
        $dateDiffObj->calculate($minWorkingHours, $time_first_last_task);
        $tempHours = $dateDiffObj->getHr();
        $tempMinuts = $dateDiffObj->getMin();
        $tempSeconds = $dateDiffObj->getSec();
        $dateDiffObj->calHrMinSec($tempHours, $tempMinuts, $tempSeconds);

        $diff_work_time = DateDiffCalculator::getToTimeFormat($tempHours, $tempMinuts, $tempSeconds);
      }
    }

    /**
     * calculating total time in a day
     */
    foreach ($taskListTemp as $row) {

      if (!empty($row->end_time)) {
        $dateDiffObj->calculate($row->start_time, $row->end_time);
        $totHours += $dateDiffObj->getHr();
        $totMinutes += $dateDiffObj->getMin();
        $totSeconds += $dateDiffObj->getSec();

        // if (isset($row->word_count)) {
        //   $wordsCount += $row->word_count;
        // }
        // $userId = TrackSession::get()->userId();
        // $countData = NewContentCount::select('count','date')->where('user_id', $row->user_id)->whereDate('date',$crrDate)->first();
        //  print_r($countData);
        

        $countData =   NewContentCount::select(
          'user_id',
          DB::raw('sum(count) as counts')
        )->where('user_id', $row->user_id)
        ->whereDate('date',$crrDate)
          ->groupBy('user_id')
          ->first();

        //  dd($countData);
        if (!empty($countData)) {
          $wordsCount = $countData->counts;
        }
      } else {
        $wordsCount = 0;
        continue;
      }

      //calculate total working hours
      DateDiffCalculator::calHrMinSec($totHours, $totMinutes, $totSeconds);
    }

    $actual_total_work_hours = DateDiffCalculator::getToTimeFormat($totHours, $totMinutes, $totSeconds);
    $total_working_hours = DateDiffCalculator::getToTimeFormat($totHours, $totMinutes, $totSeconds);
    $total_working_hours_arr = [$totHours, $totMinutes, $totSeconds];

    //when less time found
    //7.75 is min time to consider full day
    if (!$isMinTimeWorkDone && $totHours >= 7.75) {

      $totalWorkMinutes = DateDiffCalculator::intoMinutes($totHours, $totMinutes, $totSeconds);

      $remainWorkMinutes = DateDiffCalculator::intoMinutes($tempHours, $tempMinuts, $tempSeconds);

      $afterLessTime = $totalWorkMinutes - $remainWorkMinutes;

      $balanceTime = DateDiffCalculator::intoHrIsSec($afterLessTime);

      $total_working_hours = DateDiffCalculator::getToTimeFormat($balanceTime[0], $balanceTime[1], $balanceTime[2]);

      $total_working_hours_arr = [$balanceTime[0], $balanceTime[1], $balanceTime[2]];
    }

    $tempData = [
      'total_working_hours' => $total_working_hours,
      'total_working_hours_arr' => $total_working_hours_arr,
      'actual_total_work_hours' => $actual_total_work_hours,
      'wordsCount' => $wordsCount,
      'isMinTimeWorkDone' =>  $isMinTimeWorkDone,
      'diff_work_time' => $diff_work_time,
      'calculated_first_last_hours' => $calculated_first_last_hours,
    ];



    return $tempData;
  }

  // public function calculateContentTimestamp($times,$crrDateNew = null)
  // {
  //   $tempData = [];

  //   $totHours = 0;
  //   $totMinutes = 0;
  //   $totSeconds = 0;
  //   $wordsCount = 0;

  //   $isMinTimeWorkDone = true;
  //   $diff_work_time = '';
  //   $actual_total_work_hours = '';
  //   $calculated_first_last_hours = '';
  //   $taskListTemp = [];
  //   $dateDiffObject = new DateDiffCalculator();
  //   // foreach ($times as  $row_new) {
  //   //   if (!empty($row_new)) {

  //   //     $date1s = date_create($row_new->start_time);
  //   //     $date2s = date_create($row_new->end_new);
  //   //     $this->dateDiffs = date_diff($date1s, $date2s);
  //   //     $h = $this->dateDiffs->format("%H");
  //   //     dd($date2s);
  //   //   //   $dateDiffObject->calculate($row_new->start_time, $row_new->end_new);
  //   //   //   $tempHours = $dateDiffObject->getHr();
  //   //   //   $tempMinuts = $dateDiffObject->getMin();
  //   //   //   $tempSeconds = $dateDiffObject->getSec();
  //   //   //   // dd($tempSeconds);
  //   //   //   $time_first_last_task = "$tempHours:$tempMinuts:$tempSeconds";
  //   //   // dd($time_first_last_task);
  //   //     // $calculated_first_last_hours = DateDiffCalculator::getToTimeFormat($tempHours, $tempMinuts, $tempSeconds);
  //   //     // dd($calculated_first_last_hours);
  //   //   }
  //   // }
  //   // // dd($row_new->end_time);


  //   // ================================
  //   $taskListTimeTemp = [];
  //   $list = array();
  //   $time_first_last_task = '';
  //   $timeForfirLas = [];
  //   foreach ($times as $key => $rows_newd) {
  //     // dd($rows_newd->end_time);
  //     if (strtotime($crrDateNew) === strtotime(date('Y-m-d', strtotime($rows_newd->start_time)))) {
  //       $taskListTimeTemp[] = $rows_newd;
  //       unset($times[$key]);
  //     }

  //     if (!empty($rows_newd->end_time)) {
  //       $dateDiffObject->calculate($rows_newd->start_time,$rows_newd->end_time);
  //       $tempHours = $dateDiffObject->getHr();
  //       $tempMinuts = $dateDiffObject->getMin();
  //       $tempSeconds = $dateDiffObject->getSec();
  //       // dd($tempMinuts);
  //       $time_first_last_task = "$crrDateNew $tempHours:$tempMinuts:$tempSeconds";

  //       // $date = date('Y-m-d',strtotime($time_first_last_task));


  //       // dd($time_first_last_task);
  //       // $calculated_first_last_hours = DateDiffCalculator::getToTimeFormat($tempHours, $tempMinuts, $tempSeconds);
  //     }
  //   //   if($crrDateNew ===  $date){
  //   //     //   $timeForfirLas[] = $time_first_last_task;
  //   //     array_push($list,$time_first_last_task);
  //   //     }
  //     $list[$crrDateNew] = $time_first_last_task;
  //   //  dd($list);
  //   echo '<pre>';
  //   print_r($list);

  //   }
  //   //  foreach($list as $keys => $value){
  //   // //    $s = array_search("$crrDateNew",$list);
  //   //     // dd($s);

  //   //  }
  //   //  $start   = DateTime::createFromFormat('d-m-Y', '25-12-2013');
  //   //  $end     = DateTime::createFromFormat('d-m-Y', '26-12-2013');
  //   //  $matches = array();
  //   //  foreach ($list as $keys => $value) {
  //   //     //  $k = DateTime::createFromFormat('Y-m-d', $keys);


  //   //      foreach($value as $k =>$val){

  //   //      if ($keys ===  $val) {

  //   //         dd($k);
  //   //     }

  //   //      }

  //   //  }
  //   // dd($taskListTimeTemp);


  //   if (!empty($taskListTimeTemp)) {

  //       // getting time of first start task
  //       $first = reset($taskListTimeTemp);
  //       $startTime = $first->start_time;

  //       // getting end time of last start task
  //       $last = reset($taskListTimeTemp);
  //       $endTime = $last->end_time;

  //       // dd($startTime);
  //       // calculating total time duration
  //       // between start and end task time
  //       if (!empty($endTime)) {
  //         $dateDiffObject->calculate($startTime, $endTime);
  //         $tempHours = $dateDiffObject->getHr();
  //         $tempMinuts = $dateDiffObject->getMin();
  //         $tempSeconds = $dateDiffObject->getSec();
  //         // dd($tempMinuts);
  //         $time_first_last_task = "$crrDateNew $tempHours:$tempMinuts:$tempSeconds";
  //         $list[] = $time_first_last_task;
  //         // dd($time_first_last_task);
  //         $calculated_first_last_hours = DateDiffCalculator::getToTimeFormat($tempHours, $tempMinuts, $tempSeconds);
  //       }
  //       dd($list);

  //       //make current date for value getting from DB
  //       $minWorkingHours = $crrDateNew . " " . $this->minWorkingHours;


  //       // $remainTimeDiff = 0;

  //       if (strtotime($minWorkingHours) > strtotime($time_first_last_task)) {
  //           $isMinTimeWorkDone = false;

  //           // echo $timeDiff = strtotime($minWorkingHours) - strtotime($time_first_last_task);

  //           //when min duration is not completed, calculate how much
  //           $dateDiffObject->calculate($minWorkingHours, $time_first_last_task);
  //           $tempHours = $dateDiffObject->getHr();
  //           $tempMinuts = $dateDiffObject->getMin();
  //           $tempSeconds = $dateDiffObject->getSec();
  //           $dateDiffObject->calHrMinSec($tempHours, $tempMinuts, $tempSeconds);

  //           $diff_work_time = DateDiffCalculator::getToTimeFormat($tempHours, $tempMinuts, $tempSeconds);
  //         }
  //   }


    /**
     * calculating total time in a day
     */
    // foreach ($taskListTemp as $row) {

    //     if (!empty($row->end_time)) {
    //       $dateDiffObject->calculate($row->start_time, $row->end_time);
    //       $totHours += $dateDiffObject->getHr();
    //       $totMinutes += $dateDiffObject->getMin();
    //       $totSeconds += $dateDiffObject->getSec();

    //       // if (isset($row->word_count)) {
    //       //   $wordsCount += $row->word_count;
    //       // }

    //       if (isset($row->count)) {
    //         $wordsCount += $row->count;
    //       }
    //     } else {
    //       continue;
    //     }

    //     //calculate total working hours
    //     DateDiffCalculator::calHrMinSec($totHours, $totMinutes, $totSeconds);
    //   }

    //   $actual_total_work_hours = DateDiffCalculator::getToTimeFormat($totHours, $totMinutes, $totSeconds);
    //   $total_working_hours = DateDiffCalculator::getToTimeFormat($totHours, $totMinutes, $totSeconds);
    //   $total_working_hours_arr = [$totHours, $totMinutes, $totSeconds];

    //   //when less time found
    //   //7.75 is min time to consider full day
    //   if (!$isMinTimeWorkDone && $totHours >= 7.75) {

    //     $totalWorkMinutes = DateDiffCalculator::intoMinutes($totHours, $totMinutes, $totSeconds);

    //     $remainWorkMinutes = DateDiffCalculator::intoMinutes($tempHours, $tempMinuts, $tempSeconds);

    //     $afterLessTime = $totalWorkMinutes - $remainWorkMinutes;

    //     $balanceTime = DateDiffCalculator::intoHrIsSec($afterLessTime);

    //     $total_working_hours = DateDiffCalculator::getToTimeFormat($balanceTime[0], $balanceTime[1], $balanceTime[2]);

    //     $total_working_hours_arr = [$balanceTime[0], $balanceTime[1], $balanceTime[2]];
    //   }

    //   $tempData = [
    //     'total_working_hours' => $total_working_hours,
    //     'total_working_hours_arr' => $total_working_hours_arr,
    //     'actual_total_work_hours' => $actual_total_work_hours,
    //     'wordsCount' => $wordsCount,
    //     'isMinTimeWorkDone' =>  $isMinTimeWorkDone,
    //     'diff_work_time' => $diff_work_time,
    //     'calculated_first_last_hours' => $calculated_first_last_hours,
    //   ];



    //   return $tempData;
    // }



  /**
   * ::::::::::::::::::::::::::::::::::::::::
   * Check that given date is holiday or not
   * ::::::::::::::::::::::::::::::::::::::::
   */
  public function isHoliday($date, $holidays)
  {
    foreach ($holidays as $key => $value) {
      if ($date == $value) {
        return true;
      }
    }
    return false;
  }


  /**
   * Check for leave sandwich
   */
  public function checkSandwichLeave($taskList, $crrDate, $holidays, $startDate, $endDate)
  {
    // $holidays = $GLOBALS['holidays'];
    $previousDayLeave = false;
    $previousdate = $crrDate;

    //getting previous day work or not till the start day of the month
    while (new DateTime($previousdate) >= (new DateTime($startDate))) {

      //previous date
      $previousdate = date('Y-m-d', strtotime('-1 day', strtotime($previousdate)));

      $taskListCopy = clone $taskList;

      //getiing previous day work
      $data = $this->calculateForUser($taskListCopy, $previousdate);
      $total_hours = $data["total_working_hours_arr"][0];

      //current day name i.e. sunday
      $crrDay = date("l", strtotime($previousdate));

      if ($total_hours >= 4) {
        // $previousDayLeave = false;
        break;
      } else if (($this->isHoliday($previousdate, $holidays) || $crrDay === 'Sunday')) {
        // $previousDayLeave = false;
        //we need to 1 day back and check
        continue;
      } else {
        $previousDayLeave = true;
        break;
      }
    }



    $nextdate = $crrDate;

    //getting previous day work or not till the start day of the month
    while (new DateTime($nextdate) <= (new DateTime($endDate))) {

      //next day calculation
      $nextdate = date('Y-m-d', strtotime('+1 day', strtotime($nextdate)));

      $taskListCopy = clone $taskList;

      //getiing previous day work
      $data = $this->calculateForUser($taskListCopy, $nextdate);
      $total_hours = $data["total_working_hours_arr"][0];

      //current day name i.e. sunday
      $crrDay = date("l", strtotime($nextdate));

      if ($total_hours >= 4) {
        // $previousDayLeave = false;
        return false;
      } else if (($this->isHoliday($nextdate, $holidays) || $crrDay === 'Sunday')) {
        // $previousDayLeave = false;
        //we need to 1 day back and check
        continue;
      } else if ($previousDayLeave) {
        return true;
        // break;
      } else {
        return false;
      }
    }

    return false;
  }


  /**
   * Check for leave sandwich
   */
  // public function checkSandwichLeaveOld($taskList, $crrDate, $holidays,  $startDate, $endDate)
  // {
  //   // $holidays = $GLOBALS['holidays'];
  //   $previousDayLeave = false;

  //   //previous date
  //   $previousdate = date('Y-m-d', strtotime('-1 day', strtotime($crrDate)));

  //   //getiing previous day work
  //   // $data = $this->calculateForUser($taskListCopy, $previousdate);


  //   // while ($this->isHoliday($previousdate, $holidays)) {
  //   //   $previousdate = date('Y-m-d', strtotime('-1 day', strtotime($previousdate)));
  //   // }


  //   $crrDay = date("l", strtotime($previousdate));



  //   if (!($this->isHoliday($previousdate, $holidays) || $crrDay === 'Sunday')) {

  //     $taskListCopy = clone $taskList;

  //     $data = $this->calculateForUser($taskListCopy, $previousdate);
  //     $total_hours = $data["total_working_hours_arr"][0];
  //     // $wordsCount = $data['wordsCount'];
  //     // $total_minutes = $data["total_working_hours_arr"][1];

  //     // if ($total_minutes > 59) {
  //     //   $total_hours += (int) ($total_minutes / 60);
  //     //   $total_minutes = $total_minutes % 60;
  //     // }

  //     if ($total_hours < 4) {
  //       $previousDayLeave = true;
  //       // $previousDayLeave = false;
  //     }

  //     //checks for content writers
  //     // else if ($post === 'seo' && $wordsCount < 2000) {
  //     //   $previousDayLeave = true;
  //     // }
  //     // else {
  //     //   $previousDayLeave = 1;
  //     // }
  //   }
  //   // else {
  //   //   $previousDayLeave = 0;
  //   // }


  //   //next day calculation
  //   $nextdate = date('Y-m-d', strtotime('+1 day', strtotime($crrDate)));


  //   // while ($this->isHoliday($nextdate, $holidays)) {
  //   //   $nextdate = date('Y-m-d', strtotime('+1 day', strtotime($nextdate)));
  //   // }


  //   $crrDay = date("l", strtotime($nextdate));

  //   if (!($this->isHoliday($nextdate, $holidays) || $crrDay === 'Sunday')) {


  //     $taskListCopy = clone $taskList;

  //     $data = $this->calculateForUser($taskListCopy, $nextdate);
  //     $total_hours = $data["total_working_hours_arr"][0];
  //     // $wordsCount = $data['wordsCount'];
  //     // $total_minutes = $data["total_working_hours_arr"][1];

  //     // $data = workingHours($conn, $userid, $des, $nextdate);
  //     // $total_hours = $data["total_hours"];
  //     // $total_minutes = $data["total_minutes"];

  //     // if ($total_minutes > 59) {
  //     //   $total_hours += (int) ($total_minutes / 60);
  //     //   $total_minutes = $total_minutes % 60;
  //     // }

  //     if ($total_hours < 4 && $previousDayLeave) {
  //       return true;
  //     }

  //     //checks for content writers
  //     // else if ($post === 'seo' && $wordsCount < 2000  && $previousDayLeave) {
  //     //   return true;
  //     // }

  //     // if ($total_hours >= 4) {
  //     //   return false;
  //     // } else {
  //     //   if ($previousDayLeave == 1) {
  //     //     return 1;
  //     //   }
  //     // }
  //   }

  //   return false;
  // }
}
