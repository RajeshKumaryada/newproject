<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistGroupUsers extends Model
{
  protected $table  = "checklist_group_users";
  protected $primaryKey = "checklist_group_users_id";
  public $timestamps = false;


  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to
   * :::::::::::::::::::::::::::::
   */
  public function username()
  {
    return $this->belongsTo(Users::class, 'user_id')->select('user_id', 'username');
  }
}
