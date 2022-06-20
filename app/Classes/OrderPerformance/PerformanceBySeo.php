<?php

namespace App\Classes\OrderPerformance;

class PerformanceBySeo
{

  private $targetOrders = [
    ['ord' => 40, 'color' => '#007bff', 'zone' => 'bonus'],
    ['ord' => 24, 'color' => '#28a745', 'zone' => 'green'],
    ['ord' => 10, 'color' => '#ffc107', 'zone' => 'yellow'],
    ['ord' => 0, 'color' => '#dc3545', 'zone' => 'red'],
  ];



  /**
   * calculating avg of target orders in a month
   */
  public function getTagetOrdersAvg($workingDays, $totalMonthDays)
  {

    $return = [];

    foreach ($this->targetOrders as $key => $row) {
      $return[$key] = round(($row['ord'] / $totalMonthDays) * $workingDays, 2);
    }

    return $return;
  }




  /**
   * Performance calculaton based on month,
   * When month is current working month
   */
  public function monthAvg($totalOrd, $targetOrdArr)
  {

    $return = [];

    foreach ($targetOrdArr as $key => $avg) {
      if ($totalOrd > $avg) {
        $return = [
          'target_avg' => $avg,
          'target_ord' => $this->targetOrders[$key]['ord'],
          'color' => $this->targetOrders[$key]['color'],
          'zone' => $this->targetOrders[$key]['zone']
        ];
        break;
      } else {
        $return = [
          'target_avg' => $avg,
          'target_ord' => $this->targetOrders[3]['ord'],
          'color' => $this->targetOrders[3]['color'],
          'zone' => $this->targetOrders[3]['zone']
        ];
      }
    }

    return $return;
  }


  /**
   * Performance calculaton based on month,
   * When month is previous working month
   */
  public function month($totalOrd)
  {

    $return = [];

    foreach ($this->targetOrders as $key => $row) {
      if ($totalOrd > $row['ord']) {
        $return = [
          'target_ord' => $this->targetOrders[$key]['ord'],
          'color' => $this->targetOrders[$key]['color'],
          'zone' => $this->targetOrders[$key]['zone']
        ];
        break;
      } else {
        $return = [
          'target_ord' => $this->targetOrders[3]['ord'],
          'color' => $this->targetOrders[3]['color'],
          'zone' => $this->targetOrders[3]['zone']
        ];
      }
    }

    return $return;
  }
}
