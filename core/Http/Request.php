<?php

namespace Core\Http;

class Request {

  private $method;
  private $headers = [];
  private $data = [];

  public function __construct() {
    $this->method = $_SERVER['REQUEST_METHOD'];
    $this->headers = getallheaders();
    $this->data = array_merge($_GET, $_POST);
  }

  public function getRequestMethod() {
    return $this->method;
  }

  public function get($keys, $default = null) {
    return $this->getResultBasedOnKeys($this->data, $keys, $default);
  }

  public function header($header) {
    if(array_key_exists($this->headers, $header)) {
      return $this->headers[$header];
    }

    return null;
  }

  public function isPost() {
    return $this->method === 'POST';
  }

  public function isGet() {
    return $this->method === 'GET';
  }

  private function getResultBasedOnKeys($array, $keys, $default) {
    if(is_array($keys)) {
      $values = [];

      foreach($keys as $key) {
        if(isset($array[$key])) {
          $values[$key] = $array[$key] ?? $default;
        }
      }

      return $values;
    }

    if(is_string($keys)) {
      if(isset($array[$keys])) {
        return $array[$keys];
      }

      return $default;
    }

    return [];
  }
}