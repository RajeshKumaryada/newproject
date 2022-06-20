<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPageAccess extends Model
{
  protected $table = 'admin_page_access';
  protected $primaryKey = 'id';

  public $timestamps = false;


  /**
   * Has Many to Relation
   */
  public function assigndUsers()
  {
    return $this->hasMany(AdminPageAccessUsers::class, 'page_access_id');
  }
}
