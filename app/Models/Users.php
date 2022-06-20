<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Users extends Model
{
  protected $table = "users";
  protected $primaryKey = "user_id";
  protected $hidden = ['password'];




  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to
   * :::::::::::::::::::::::::::::
   */
  public function department()
  {
    return $this->belongsTo(EmpDepartment::class, 'department');
  }



  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to
   * :::::::::::::::::::::::::::::
   */
  public function post()
  {
    return $this->belongsTo(EmpPost::class, 'post');
  }


  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to
   * :::::::::::::::::::::::::::::
   */
  public function empPost()
  {
    return $this->belongsTo(EmpPost::class, 'post');
  }



  /**
   * :::::::::::::::::::::::::::::
   * Relationship belongs to
   * ::::::::::::::::::::::::::::: 
   */
  public function designation()
  {
    return $this->belongsTo(EmpDesignation::class, 'designation');
  }


  /**
   * :::::::::::::::::::::::::::::
   * Relationship has one
   * :::::::::::::::::::::::::::::
   */
  public function usersInfo()
  {
    return $this->hasOne(UsersInfo::class, 'user_id');
  }


  /**
   * :::::::::::::::::::::::::::::
   * Relationship has one
   * :::::::::::::::::::::::::::::
   */
  // public function usersGender()
  // {
  //   return $this->hasOne(UsersInfo::class, 'user_id')->select('user_id', 'gender');
  // }


  /**
   * :::::::::::::::::::::::::::::
   * Relationship has many
   * :::::::::::::::::::::::::::::
   */
  public function seoWorkReport()
  {
    return $this->hasMany(SeoWorkReport::class, 'user_id');
  }


  /**
   * :::::::::::::::::::::::::::::
   * Relationship has many
   * :::::::::::::::::::::::::::::
   */
  public function siteUsersRelation()
  {
    return $this->hasMany(WebsiteUsersRelation::class, 'user_id');
  }
}
