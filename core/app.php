<?php

namespace Core;

use Core\Service\Container;
use Core\Routing\Router;
use core\Command\Commander;

class App {

  private $serverType;
  private $config = [];
  private $singletons = [];

  public function __construct(string $serverType) {
    $this->serverType = $serverType;
    $this->config = require_once config_path('app.php');

    $this->singletons['container'] = new Container();
    $this->singletons['router'] = new Router();
    $this->singletons['commander'] = new Commander();
  }

  public function config(string $key) {
    return $this->config[$key];
  }

  public function getServerType() {
    return $this->serverType;
  }

  public function __call($method, $arguments) {
    foreach($this->singletons as $key => $singleton) {
      if(method_exists($singleton, $method)) {
        return $singleton->{$method}(...$arguments);
      }
    }
  }

  public function __get($name) {
    foreach ($this->singletons as $key => $value) {
      if($key == $name) {
        return $value;
      }
    }

    return null;
  }
}