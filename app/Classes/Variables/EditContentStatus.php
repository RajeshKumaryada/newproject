<?php

namespace App\Classes\Variables;


class EditContentStatus
{
  public $status = [
    1 => 'Requested',
    2 => 'Assigned',
    3 => 'Writing',
    4 => 'Draft',
    5 => 'Unapproved',
    6 => 'Change Requested',
    7 => 'Approved',
  ];



  /**
   * Function that return types array
   */
  public function all()
  {
    return $this->status;
  }



  /**
   * Function that return key
   */
  public function key(string $type)
  {
    return array_search($type, $this->status);
  }



  /**
   * Function that return value
   */
  public function value(string $key)
  {
    if (!empty($this->status[$key])) {
      return $this->status[$key];
    }

    return null;
  }


  /**
   * Static function that return 
   * Current class new object
   */
  public static function get()
  {
    return new EditContentStatus();
  }
}
