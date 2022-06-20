<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TraceLocation extends Model
{
  protected $table = "trace_location";
  protected $primaryKey = "id";

  public $timestamps = false;




  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to
   * :::::::::::::::::::::::::::::
   */
  public function devTask()
  {
    return $this->belongsTo(DeveloperTask::class, 'task_id');
  }
}
