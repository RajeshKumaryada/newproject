<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersDocumentTemp extends Model
{
    protected $table = "user_documents_temp";
    protected $primaryKey = "id";

    public function userName(){
        return $this->belongsTo(Users::class,'user_id');
    }
}
