<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = "users_address";
    protected $primaryKey = "id";
    public $timestamps = false;

}
