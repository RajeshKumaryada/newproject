<?php

namespace App\Classes\Log;

use App\Models\LogUserLogin;

class Log4UserLogin
{

  private $event;
  private $info;


  public function __construct()
  {
    $this->event = null;
    $this->info = null;
  }



  public function event($event)
  {
    $this->event = $event;

    return $this;
  }



  public function info($info)
  {
    $this->info = $info;

    return $this;
  }




  /**
   * save log into DB
   */
  public function save($userId)
  {
    $insert = [
      'user_id' => $userId,
      'date_time' => date('Y-m-d H:i:s'),
      'event' => $this->event,
      'ip' => request()->ip(),
      'info' => $this->info,
    ];

    LogUserLogin::insert($insert);
  }


  public static function init()
  {
    return new Log4UserLogin();
  }
}
