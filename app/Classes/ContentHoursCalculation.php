<?php

namespace App\Classes;


class ContentHoursCalculation
{
  /**
   * This function for User end
   * Calculate Working hours for today working user
   */
  public function calculate($taskList)
  {
    $dateDiffObj = new DateDiffCalculator();

    $tempData = [];

    $totHours = 0;
    $totMinutes = 0;
    $totSeconds = 0;


    /**
     * calculating total time in a day
     */
    foreach ($taskList as $row) {

      if (!empty($row->end_time)) {
        $dateDiffObj->calculate($row->start_time, $row->end_time);
        $totHours += $dateDiffObj->getHr();
        $totMinutes += $dateDiffObj->getMin();
        $totSeconds += $dateDiffObj->getSec();
      } else {
        continue;
      }

      //calculate total working hours
      DateDiffCalculator::calHrMinSec($totHours, $totMinutes, $totSeconds);
    }

    $total_working_hours = DateDiffCalculator::simpleFormat($totHours, $totMinutes, $totSeconds);
    $total_working_hours_arr = [$totHours, $totMinutes, $totSeconds];
    $total_working_hour_plane = DateDiffCalculator::planeFormat($totHours, $totMinutes, $totSeconds);
    

    $tempData = [
      'work_hours' => $total_working_hours,
      'work_hours_arr' => $total_working_hours_arr,
      'total_working_hour_plane' => $total_working_hour_plane
    ];

    return $tempData;
  }
}
