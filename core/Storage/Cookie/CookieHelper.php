<?php

namespace Core\Storage\Cookie;

use Core\Storage\Cookie\CookieContainer;

class CookieHelper {

  public function set($cookie, $value) {
    if(is_array($value)) {
      $value = json_encode($value);
    }

    setcookie($cookie, $value, time()+60*60*24*365, '/');
  }

  public function get($cookie) {
    $value = $_COOKIE[$cookie];

    $jsonValue = json_decode($value, true);

    if(json_last_error() === JSON_ERROR_NONE) {
      $value = $jsonValue;
    }

    return $value;;
  }
}