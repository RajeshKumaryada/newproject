<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class NewContentRemarks extends Model
{
  protected $table = 'new_content_remarks';
  protected $primaryKey = 'id';

  public $timestamps = false;


  /**
   * Belongs to
   */
  public function userName()
  {
    return $this->belongsTo(Users::class, 'user_id')->select('user_id', 'username', 'email');
  }
}
