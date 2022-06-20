<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class NewContentTask extends Model
{
  protected $table = "new_content_task";
  protected $primaryKey = "id";

  public $timestamps = false;



  /**
   * Has many relationship
   */
  public function contentRemarks()
  {
    return $this->hasMany(NewContentRemarks::class, 'new_content_id');
  }



  /**
   * Has many relationship
   */
  public function contentEdits()
  {
    return $this->hasOne(NewContentEdits::class, 'new_content_id');
  }


  /**
   * Belongs to relationship
   */
  public function requestByUser()
  {
    return $this->belongsTo(Users::class, 'request_by')->select('user_id', 'username', 'email');
  }



  /**
   * Belongs to relationship
   */
  public function assignToUser()
  {
    return $this->belongsTo(Users::class, 'assign_to')->select('user_id', 'username', 'email');
  }
}
