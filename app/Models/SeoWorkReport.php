<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoWorkReport extends Model
{
  protected $table  = "seo_work_report";
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


  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to
   * :::::::::::::::::::::::::::::
   */
  public function seoTaskList()
  {
    return $this->belongsTo(SeoTaskList::class, 'task_id');
  }
}
