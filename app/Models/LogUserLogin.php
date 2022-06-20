<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogUserLogin extends Model
{
  protected $table = 'log_user_login';
  protected $primaryKey = 'ul_id';

  public $timestamps = false;
}
