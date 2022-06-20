<?php

namespace App\Classes\Functions;


class Fns
{
  public function wordCount($str)
  {

    $str = preg_replace("/(^\s*)|(\s*$)/i", "", $str);
    $str = preg_replace("/[ ]{2,}/i", " ", $str);
    $str = preg_replace("/\n /", "\n", $str);

    if ($str != '' || $str != null) {
      return count(explode(' ', $str));
    }

    return 0;
  }


  public static function init()
  {
    return new self();
  }
}
