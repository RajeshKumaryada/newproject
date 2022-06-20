<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignTaskStatus extends Model
{
    protected $table  = "assign_task_status";
    protected $primaryKey = "id";
    public $timestamps = false;
}
