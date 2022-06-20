<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Website extends Model
{
    protected $table = "website_info";
    protected $primaryKey = "id";

    public $timestamps = false;
}
