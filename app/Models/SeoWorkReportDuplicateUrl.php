<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoWorkReportDuplicateUrl extends Model
{
  protected $table  = "seo_wr_duplicate_url";
  protected $primaryKey = "id";
  public $timestamps = false;



  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to
   * :::::::::::::::::::::::::::::
   */
  public function seoWorkReport()
  {
    return $this->belongsTo(SeoWorkReport::class, 'work_report_id');
  }
}
