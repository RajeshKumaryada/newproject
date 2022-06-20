<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSalary extends Model
{
    protected $table = "users_salary";
    protected $primaryKey = "id";
    public $timestamps = false;
}
