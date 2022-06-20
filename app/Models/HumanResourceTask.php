<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HumanResourceTask extends Model
{
  protected $table  = "hr_task";
  protected $primaryKey = "id";
  public $timestamps = false;


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
