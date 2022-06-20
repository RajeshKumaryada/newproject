<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
  protected $table  = "checklist";
  protected $primaryKey = "checklist_id";
  public $timestamps = false;


  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to
   * :::::::::::::::::::::::::::::
   */
  public function checklistGroup()
  {
    return $this->belongsTo(ChecklistGroup::class, 'checklist_group_id');
  }
}
