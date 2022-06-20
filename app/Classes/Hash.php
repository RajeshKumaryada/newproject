<?php

namespace App\Classes;


class Hash
{


  //=============================
  // generate and return hash
  //=============================
  public static function get(string $str)
  {
    return hash('snefru', $str);
  }



  //=============================
  // matching new and old hash
  //=============================
  /*public static function match($newHash, $oldHash)
  {
    return hash_equals($newHash, $oldHash);
  }*/



  //==============================
  // generate and return random string
  //===============================
  public static function generateRandStr($length = 10)
  {
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
  }
}
