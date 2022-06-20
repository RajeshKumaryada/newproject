<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
  protected $table = "options_tbl";
  protected $primaryKey = "opt_id";
  public $timestamps = false;
}
