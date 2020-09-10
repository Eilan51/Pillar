<?php

namespace Core\Service;

use Exception;

class Container {

  private $bindings = [];

  public function bind($key, $value) {
    $this->bindings[$key] = $value;
  }

  public function singleton($key, $value) {
    if(is_callable($value) && $value instanceof \Closure) {
      $this->bind($key, call_user_func($value));
    } else {
      $this->bind($key, $value);
    }
  }

  public function resolve($key) {
    if(!array_key_exists($key, $this->bindings)) {
      throw new Exception('Key ' . $key . ' not found in service container!');
    }

    $binding = $this->bindings[$key];

    if(is_callable($binding) && $binding instanceof \Closure) {
      return call_user_func($binding);
    }

    return $binding;
  }
}