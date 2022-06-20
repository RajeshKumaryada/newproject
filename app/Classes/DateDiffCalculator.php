<?php

/**
 * This class is used for Date difference calculation
 */

namespace App\Classes;

class DateDiffCalculator
{

  private $dateDiff;



  public function calculate($startDate, $endDate)
  {
    $date1 = date_create($startDate);
    $date2 = date_create($endDate);
    $this->dateDiff = date_diff($date1, $date2);
  }


  public function getHr()
  {
    return $this->dateDiff->format("%H");
  }


  public function getMin()
  {
    return $this->dateDiff->format("%I");
  }


  public function getSec()
  {
    return $this->dateDiff->format("%S");
  }


  public function getTotalTime($format)
  {
    return $this->dateDiff->format($format);
  }


  public static function calHrMinSec(&$hr, &$min, &$sec)
  {
    if ($sec >= 60) {
      $min = $min + (int)floor($sec / 60);
      $sec = $sec % 60;
    }

    if ($min >= 60) {
      $hr = $hr + (int)floor($min / 60);
      $min = $min % 60;
    }
  }

  public static function calHrMinSecNew($hr, $min, $sec)
  {
    if ($sec >= 60) {
      $min = $min + (int)floor($sec / 60);
      $sec = $sec % 60;
    }

    if ($min >= 60) {
      $hr = $hr + (int)floor($min / 60);
      $min = $min % 60;
    }
  }
  


  public static function getToTimeFormat($hr, $min, $sec)
  {
    if ($hr < 4) {
      return "<span class='text-danger'>{$hr}h {$min}m {$sec}s";
    } else if ($hr < 8) {
      return "<span class='text-primary'>{$hr}h {$min}m {$sec}s";
    } else {
      return "<span class='text-success'>{$hr}h {$min}m {$sec}s";
    }
  }


  /**
   * Simple Format
   */
  public static function simpleFormat($hr, $min, $sec)
  {
    return "<span class='simple-format'>{$hr}h {$min}m {$sec}s";
  }

   /**
   * Plane Format
   */
  public static function planeFormat($hr, $min, $sec)
  {
    return "{$hr}h {$min}m {$sec}s";
  }



  /**
   * Convert time into minutes
   */
  public static function intoMinutes($h, $i, $s)
  {

    $toMin = ($h * 60) + $i;

    $s = round($s / 60, 2);

    $toMin += $s;

    return $toMin;
  }


  /**
   * Convert time into minutes
   */
  public static function intoHrIsSec($minutes)
  {

    $hrs = (int) floor($minutes / 60);

    $min = $minutes % 60;

    $sec = $minutes - (($hrs * 60)  + ($min * 60));

    $sec = ($sec > 0) ? (int) floor($sec * 60) : 0;
    return [$hrs, $min, $sec];
  }

  /**
   * Time in Seconds
   */
  public static function changeHrMinSec($hr, $min, $sec)
  {
    $timeInSec =  $hr * 3600 + $min * 60 +  $sec;
    return  $timeInSec;
  }
}
