<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeExpenses extends Model
{
    protected $table = "office_expenses";
    protected $primaryKey = "id";
    public $timestamps = false;

    /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to
   * :::::::::::::::::::::::::::::
   */
  public function username()
  {
    return $this->belongsTo(Users::class, 'user_id')->select('user_id', 'username');
  }
}
