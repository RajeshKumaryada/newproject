<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationsUsers extends Model
{
  protected $table = "notifications_users";
  protected $primaryKey = "id";

  public $timestamps = false;




  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to
   * :::::::::::::::::::::::::::::
   */
  public function notifications()
  {
    return $this->belongsTo(Notifications::class, 'notification_id');
  }




  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to
   * :::::::::::::::::::::::::::::
   */
  public function users()
  {
    return $this->belongsTo(Users::class, 'user_id');
  }
}
