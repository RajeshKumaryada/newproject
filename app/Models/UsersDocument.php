<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersDocument extends Model
{
    protected $table = "user_documents";
    protected $primaryKey = "id";

    public function usersDocumentTemp()
    {
        return $this->hasOne(UsersDocumentTemp::class, 'user_doc_id');
    }
}
