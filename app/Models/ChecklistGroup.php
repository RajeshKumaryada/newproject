<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistGroup extends Model
{
  protected $table  = "checklist_group";
  protected $primaryKey = "checklist_group_id";
  public $timestamps = false;



  /**
   * :::::::::::::::::::::::::::::
   * Relationship has many
   * :::::::::::::::::::::::::::::
   */
  public function groupUsers()
  {
    return $this->hasMany(ChecklistGroupUsers::class, 'checklist_group_id');
  }

}
