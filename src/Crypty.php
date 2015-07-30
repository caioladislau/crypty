<?php namespace Sysvale;

class Crypty
{
  private static $key = "WmtZ1F0LPcyli5zyvBiZWKgbSiu1i3WZ";

  public static function encrypt($string) {
    $key = md5(self::$key);
    $td = mcrypt_module_open('des', '','cfb', '');
    $key = substr($key, 0, mcrypt_enc_get_key_size($td));
    $iv_size = mcrypt_enc_get_iv_size($td);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    if (mcrypt_generic_init($td, $key, $iv) != -1) {
      $c_t = mcrypt_generic($td, $string);
      mcrypt_generic_deinit($td);
      mcrypt_module_close($td);
      $c_t = $iv.$c_t;
      return base64_encode($c_t);
    } else {
      return "error";
    }
  }

  public static function decrypt($string) {
    $string = base64_decode($string);
    $key = md5(self::$key);
    $td = mcrypt_module_open('des', '','cfb', '');
    $key = substr($key, 0, mcrypt_enc_get_key_size($td));
    $iv_size = mcrypt_enc_get_iv_size($td);
    $iv = substr($string,0,$iv_size);
    $string = substr($string,$iv_size);
    if (mcrypt_generic_init($td, $key, $iv) != -1) {
      $c_t = mdecrypt_generic($td, $string);
      mcrypt_generic_deinit($td);
      mcrypt_module_close($td);
      return $c_t;
    } else {
      return "error";
    }
  }

}