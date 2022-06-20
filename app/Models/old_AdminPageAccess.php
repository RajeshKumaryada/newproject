<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPageAccess extends Model
{
  protected $table = 'admin_page_access';
  protected $primaryKey = 'id';

  public $timestamps = false;



  /**
   * Belongs to Relation
   */
  public function users()
  {
    return $this->belongsTo(Users::class, 'user_id');
  }
}
