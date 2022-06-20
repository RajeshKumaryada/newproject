<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersFeedbackFiles extends Model
{
    protected $table = "user_feedback_files";
    protected $primaryKey = "id";
    public $timestamps = false;
}
