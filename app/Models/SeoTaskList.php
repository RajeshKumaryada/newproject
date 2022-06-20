<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoTaskList extends Model
{
  protected $table  = "seo_task_list";
  protected $primaryKey = "id";
  public $timestamps = false;
}
