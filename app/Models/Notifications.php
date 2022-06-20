<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
  protected $table = "notifications";
  protected $primaryKey = "id";

  public $timestamps = false;


  const NOTI_SINGLE = "single";
  const NOTI_ALL = "all";
}
