<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkTeamInfo extends Model
{
  protected $table = "work_team_info";
  protected $primaryKey = "wt_id";



  /**
   * Has many relation
   */
  public function workTeamMembers()
  {
    return $this->hasMany(WorkTeamMembers::class, 'work_team_id')->orderBy('member_type', 'asc');
  }



  /**
   * Has Many Relation
   */
  public function teamLeaders()
  {
    return $this->hasMany(WorkTeamMembers::class, 'work_team_id')
      ->where('member_type', 'team_leader')
      ->orderBy('member_type', 'asc');
  }
}
