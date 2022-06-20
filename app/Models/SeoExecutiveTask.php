<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoExecutiveTask extends Model
{
  protected $table  = "seo_task";
  protected $primaryKey = "id";
  public $timestamps = false;


  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to SEO
   * :::::::::::::::::::::::::::::
   */
  public function seoTaskList()
  {
    return $this->belongsTo(SeoTaskList::class, 'task');
  }


  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to SEO
   * :::::::::::::::::::::::::::::
   */
  public function users()
  {
    return $this->belongsTo(Users::class, 'user_id');
  }
}
