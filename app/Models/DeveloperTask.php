<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeveloperTask extends Model
{
  protected $table  = "developer_task";
  protected $primaryKey = "id";
  public $timestamps = false;

  // use Awobaz\Compoships\Compoships;
  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to
   * :::::::::::::::::::::::::::::
   */
  public function users()
  {
    return $this->belongsTo(Users::class, 'user_id');
  }




  public function traceLocation()
  {

    return $this->hasMany(TraceLocation::class, 'task_id', 'id')
      ->where('trace_location.user_id', 'developer_task.user_id');

    // return $this->hasMany(TraceLocation::class, ['task_id', 'user_id'], ['id', 'user_id']);
  }
}
