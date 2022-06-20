<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersInfo extends Model
{
  protected $table = "users_info";
  protected $primaryKey = "id";
  public $timestamps = false;


   /**
     * Relationship with users
     */
    public function users()
  {
    return $this->belongsTo(Users::class,'user_id');
  }
}
