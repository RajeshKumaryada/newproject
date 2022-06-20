<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteUsersRelation extends Model
{
  protected $table  = "website_users_relation";
  protected $primaryKey = "id";
  public $timestamps = false;


  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to
   * :::::::::::::::::::::::::::::
   */
  public function siteInfo()
  {
    return $this->belongsTo(WebsiteInfo::class, 'site_id');
  }


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
