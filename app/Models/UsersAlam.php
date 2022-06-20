<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UsersAlam extends Model
{
    protected $table = "users_alarms";
    protected $primaryKey = "id";
    public $timestamps = false;
}
