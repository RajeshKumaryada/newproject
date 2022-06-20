<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationsLastSeen extends Model
{
  protected $table = "notifications_last_seen";
  protected $primaryKey = "id";

  public $timestamps = false;
}
