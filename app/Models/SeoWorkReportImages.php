<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoWorkReportImages extends Model
{
  protected $table  = "seo_work_report_images";
  protected $primaryKey = "id";
  public $timestamps = false;


  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to
   * :::::::::::::::::::::::::::::
   */
  // public function seoWorkReport()
  // {
  //   return $this->belongsTo(SeoWorkReport::class, 'work_report_id');
  // }
}
