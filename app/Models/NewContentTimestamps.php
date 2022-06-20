<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class NewContentTimestamps extends Model
{
  protected $table = "new_content_timestamps";
  protected $primaryKey = "id";

  public $timestamps = false;



  /**
   * Belongs to relationship
   */
  public function contentEdits()
  {
    return $this->belongsTo(NewContentEdits::class, 'new_content_edits_id');
  }
}
