<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPageAccessUsers extends Model
{
  protected $table = 'admin_page_access_users';
  protected $primaryKey = 'id';

  public $timestamps = false;


  public function pageUrl()
  {
    return $this->belongsTo(AdminPageAccess::class, 'page_access_id');
  }


  /**
   * Belongs to Relation
   */
  public function users()
  {
    return $this->belongsTo(Users::class, 'user_id');
  }


  /**
   * Belongs to Relation
   */
  public function userName()
  {
    return $this->belongsTo(Users::class, 'user_id')->select('user_id', 'username');
  }
}
