<?php

namespace App\Classes;

use App\Models\AssignTask;

class TrackSession
{

  // protected $trackSession;
  public $userId;
  public $userName;
  public $email;
  public $department;
  public $post;
  public $designation;

  //date of user registration
  public $createdAt;

  const USER_SESSION = 'user_session';
  const ADMIN_SESSION = 'admin_session';



  /**
   * 
   */
  public function __construct()
  {
    // $trackSession = request()->session()->get(TrackSession::USER_SESSION);
    // $this->trackSession = unserialize($trackSession);
  }



  /**
   * 
   */
  public function userId()
  {
    return $this->userId;
  }



  /**
   * 
   */
  public function userName()
  {
    return $this->userName;
  }


  /**
   * 
   */
  public function postId()
  {
    return $this->post;
  }


  /**
   * 
   */
  public function createdAt()
  {
    return $this->createdAt;
  }


  /**
   * 
   */
  public static function get()
  {
    $trackSession = request()->session()->get(self::USER_SESSION);
    return unserialize($trackSession);
  }


  /**
   * This for Admin
   */
  public static function getAdmin()
  {
    $trackSession = request()->session()->get(self::ADMIN_SESSION);
    return unserialize($trackSession);
  }


  /**
   * 
   */
  public static function has()
  {
    return request()->session()->has(self::USER_SESSION);
  }


  /**
   * 
   */
  public static function hasAdmin()
  {
    return request()->session()->has(self::ADMIN_SESSION);
  }

  public function getAssignId(){

    $id = $this->userId();
    $list = [];
    $list = AssignTask::select('id')->where('user_id', $id)
    ->where('status',0)
    ->orderBy('id','DESC')
    ->get();

    $id = [];

    foreach($list as $row){
      $i = array_push($id,$row->id);
    }
    $id = implode(',',$id); 
     return $id;
    
  }
}
