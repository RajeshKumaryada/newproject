<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddressTemp extends Model
{
    protected $table = "users_address_temp";
    protected $primaryKey = "id";
    public $timestamps = false;

    public function userName(){
        return $this->belongsTo(Users::class,'user_id');
    }
}
