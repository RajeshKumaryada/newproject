<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersFeedback extends Model
{
    protected $table = "user_feedback";
    protected $primaryKey = "id";
    public $timestamps = false;


    public function users(){
        return $this->belongsTo(Users::class,'user_id');
    }

    
}
