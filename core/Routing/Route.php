<?php

namespace Core\Routing;

class Route {

  public const ERROR_404 = '404';

  private $url;
  private $method;
  private $destination;
  private $precons;

  private $params = [];

  private $name;

  public function __construct($url, $method, $destination, $precons) {
    $this->url = $url;
    $this->method = $method;
    $this->destination = $destination;
    $this->precons = $precons;

    $this->parseParams();
  }

  public static function get(string $url, string $destination, array $precons = []) {
    return self::createRoute($url, 'GET', $destination, $precons);
  }

  public static function post(string $url, string $destination, array $precons = []) {
    return self::createRoute($url, 'POST', $destination, $precons);
  }

  public static function error($errorCode, string $destination) {
    return self::createRoute($errorCode, '', $destination, [])->name($errorCode);
  }

  private static function createRoute(string $url, string $method, string $destination, array $precons) {
    $route = new Route($url, $method, view($destination), $precons);

    app()->router->addRoute($route);

    return $route;
  }

  public function __toString() {
    return $this->url;
  }

  public function getUrl() {
    return $this->url;
  }

  public function getRequestMethod() {
    return $this->method;
  }

  public function getPrecons() {
    return $this->precons;
  }

  public function getName() {
    return $this->name;
  }

  public function getDestination() {
    return $this->destination;
  }

  public function name(string $name) {
    $this->name = $name;
  }

  private function parseParams() {
    $routeParts = explode('/', $this->url);

    $params = [];

    for($i = 0; $i < count($routeParts); $i++) {
      $routePart = $routeParts[$i];

      if(substr($routePart, 0, 1) !== ':') {
        continue;
      }

      $params[substr($routePart, 1)] = $i;
    }

    $this->params = $params;
  }
}