<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkTeamMembers extends Model
{
  protected $table = "work_team_members";
  protected $primaryKey = "wt_id";

  public $timestamps = false;


  /**
   * Belongs to relation
   */
  public function workTeamInfo()
  {
    return $this->belongsTo(WorkTeamInfo::class, 'work_team_id');
  }


  public function users()
  {
    return $this->belongsTo(Users::class, 'user_id');
  }


  /**
   * Belongs to relation
   */
  public function username()
  {
    return $this->belongsTo(Users::class, 'user_id')->select('user_id', 'username');
  }
}
