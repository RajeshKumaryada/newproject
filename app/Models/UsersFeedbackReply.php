<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersFeedbackReply extends Model
{
    protected $table = "user_feedback_reply";
    protected $primaryKey = "id";
    public $timestamps = false;

    /**
     * Relationship with users
     */
    public function users()
  {
    return $this->belongsTo(Users::class,'user_id');
  }
}
