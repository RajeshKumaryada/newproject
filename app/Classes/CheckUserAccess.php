<?php

namespace App\Classes;

use App\Models\AdminPageAccessUsers;
use Illuminate\Support\Facades\Request;

class CheckUserAccess
{

  public static function check($userId, $crrPageArr)
  {
    $pageList = AdminPageAccessUsers::with(['pageUrl'])
      ->where('user_id', $userId)->get();

    foreach ($pageList as $row) {
      $dbPageArr = (explode('/', str_replace(url('') . '/', '', $row->pageUrl->page_url)));

      $isValid = self::arrMatch($dbPageArr, $crrPageArr);


      if ($isValid === true)
        return true;
    }



    return false;
  }


  public static function arrMatch($arr1, $arr2)
  {
    $isMatch = false;
    for ($i = 0; $i < count($arr1) && $i < count($arr2); $i++) {
      if ($arr1[$i] === $arr2[$i]) {
        $isMatch = true;
      } else {
        return false;
      }
    }
    return $isMatch;
  }
}
