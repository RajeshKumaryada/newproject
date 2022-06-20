<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class NewContentEdits extends Model
{
  protected $table = "new_content_edits";
  protected $primaryKey = "id";

  public $timestamps = false;



  /**
   * Has many relationship
   */
  public function contentTimestamps()
  {
    return $this->hasMany(NewContentTimestamps::class, 'new_content_edits_id');
  }


  /**
   * Has many relationship
   */
  public function timeLastUpdate()
  {
    return $this->hasOne(NewContentTimestamps::class, 'new_content_edits_id')->orderBy('end_time', 'DESC');
  }


  /**
   * Belongs to relationship
   */
  public function contentTask()
  {
    return $this->belongsTo(NewContentTask::class, 'new_content_id');
  }
}
