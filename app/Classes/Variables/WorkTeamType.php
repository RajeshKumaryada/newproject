<?php

namespace App\Classes\Variables;

class WorkTeamType
{
  public $types = [
    1 => 'SEO Sales',
    2 => 'SEO IT',
    3 => 'Content Writers',
  ];



  /**
   * Function that return types array
   */
  public function all()
  {
    return $this->types;
  }



  /**
   * Function that return key
   */
  public function key(string $type)
  {
    return array_search($type, $this->types);
  }



  /**
   * Function that return value
   */
  public function value(string $key)
  {
    if (!empty($this->types[$key])) {
      return $this->types[$key];
    }

    return null;
  }


  /**
   * Static function that return 
   * Current class new object
   */
  public static function get()
  {
    return new WorkTeamType();
  }
}
