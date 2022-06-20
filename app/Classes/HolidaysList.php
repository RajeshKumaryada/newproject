<?php

namespace App\Classes;

use DateInterval;
use DatePeriod;
use DateTime;
use mysqli;

class HolidaysList
{

  public function fetch()
  {

    //Change DB Driver to localhost when live
    $_DBSERVER = "localhost";
    // $_DBSERVER = "183.83.43.54:3306";
    $_DB = "u1469889_leave_portal";
    $_DBUSER = "root";
    $_DBPASS = "";

    // $holidays = [
    //   '2021-07-10',
    //   '2021-07-23',
    //   '2021-07-24',
    //   '2021-07-25',
    //   '2021-07-26'
    // ];

    $conn = new mysqli($_DBSERVER, $_DBUSER, $_DBPASS, $_DB);

    if ($conn->connect_error) {
      die("Connection failed");
    }



    $sql = "SELECT `start_date`, `end_date`, `total_days` FROM `holidays`";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        if (((int)$row['total_days']) > 1) {
          $start_date = date('Y-m-d', strtotime($row['start_date']));
          $end_date = date('Y-m-d', strtotime($row['end_date']));
          $dates = $this->findDays($start_date, $end_date);
          foreach ($dates as $key => $value) {
            $holidays[] = $value;
          }
        } else {
          $holidays[] = date("Y-m-d", strtotime($row['start_date']));
        }
      }
    }

    $conn->close();

    return $holidays;
  }


  private function findDays($start, $end)
  {
    $period = new DatePeriod(
      new DateTime($start),
      new DateInterval('P1D'),
      new DateTime($end)
    );
    foreach ($period as $key => $value) {
      $holidays[] = $value->format('Y-m-d');
    }
    $holidays[] = $end;
    return $holidays;
  }
}
