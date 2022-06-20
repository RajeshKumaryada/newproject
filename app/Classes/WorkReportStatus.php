<?php

namespace App\Classes;

class WorkReportStatus
{

  public static function getStaus(int $status)
  {
    if ($status === 1)
      return "Completed";

    return "Incomplete";
  }
}
