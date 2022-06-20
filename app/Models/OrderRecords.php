<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderRecords extends Model
{
  protected $table  = "order_records";
  protected $primaryKey = "ord_id";
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


  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to
   * :::::::::::::::::::::::::::::
   */
  public function websiteInfo()
  {
    return $this->belongsTo(WebsiteInfo::class, 'website_id');
  }
}
