<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteInfo extends Model
{
  protected $table  = "website_info";
  protected $primaryKey = "id";
  public $timestamps = false;


  /**
   * :::::::::::::::::::::::::::::
   * Relationship Has Many
   * :::::::::::::::::::::::::::::
   */
  public function websiteUsersRelation()
  {
    return $this->hasMany(WebsiteUsersRelation::class, 'site_id');
  }
}
