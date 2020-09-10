<?php

namespace Core\Storage\Session;

class SessionHelper {

  private $data = [];

  public function __construct() {
    $this->data = $_SESSION;
  }

  public function get($key) {
    if(is_array($key)) {
      $values = [];

      foreach ($key as $sessionKey => $value) {
        $values[$sessionKey] = $this->data[$sessionKey] ?? null;
      }

      return $values;
    }

    if(array_key_exists($key, $this->data)) {
      return $this->data[$key];
    }

    return null;
  }

  public function set($key, $value = null) {
    if(is_array($key)) {
      foreach ($key as $sessionKey => $sessionValue) {
        if($this->isAssoc($key)) {
          $this->setData($sessionKey, $sessionValue);
        } else {
          $this->setData($key, $value);
        }
      }
    } else {
      $this->setData($key, $value);
    }
  }

  private function setData($key, $value) {
    $_SESSION[$key] = $value;
    $this->data[$key] = $value; 
  }

  /**
  * Checks if an array is an associative array
  *
  * @param array $array - The array
  *
  * @return bool
  */
  private function isAssoc(array $array): bool {
    return array_keys($array) !== range(0, count($array) - 1);
  }
}