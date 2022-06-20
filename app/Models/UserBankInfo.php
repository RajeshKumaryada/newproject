<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBankInfo extends Model
{
    protected $table = "users_bank_info";
    protected $primaryKey = "id";

    public function usersBankInfoTemp(){
        return $this->hasOne(UsersBankInfoTemp::class,'user_bank_info_id');
    }

}
