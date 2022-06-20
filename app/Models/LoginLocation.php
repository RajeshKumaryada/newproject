<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLocation extends Model
{
    protected $table  = "login_locate";
    protected $primaryKey = "id";
    public $timestamps = false;
   
}
