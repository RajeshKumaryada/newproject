<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersAlarmRecord extends Model
{
    protected $table = "users_alarm_records";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function userName(){
        return $this->belongsTo(Users::class,'user_id');
    }
}
