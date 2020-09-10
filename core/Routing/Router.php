<?php

namespace Core\Routing;

use Exception;

use Core\Routing\Route;
use Core\Http\Request;
use Core\Http\Response;

class Router {

  private $routes = [];

  public function getRouteByName(string $name) {
    foreach($this->routes as $route) {
      if($route->getName() === $name) {
        return $route;
      }
    }

    throw new Exception('Route with name ' . $name . ' does not exist!');
  }

  public function addRoute(Route $route) {
    $this->routes[] = $route;
  }

  public function handleRequest(string $uri, Request $request): Response {
    $route = $this->getRoute($uri, $request->getRequestMethod());
    $response = new Response($route[0], $route[1]->getDestination());;

    $precons = $route[1]->getPrecons();

    if(count($precons)) {
      $definedPrecons = require_once config_path('precons.php');

      foreach($precons as $preconString) {
        $precon = new $definedPrecons[$preconString];

        $request = $precon->validate($request);

        if($request instanceof Response) {
          $response = $request;
          break;
        }
      }
    }

    $params = $route[2];

    if(count($params)) {
      $response->setViewData($params);
    }

    return $response;
  }

  private function getRoute(string $uri, string $method) {
    $params = [];

    foreach($this->routes as $route) {
      if($route->getRequestMethod() !== $method) {
        continue;
      }

      if($route->getUrl() === $uri) {
        return [Response::OK ,$route, $params];
      }

      // Skip root route
      if($route->getUrl() === '/') {
        continue;
      }

      $urlParts = explode('/', $uri);
      $routeParts = explode('/', $route);

      if(count($urlParts) !== count($routeParts)) {
        continue;
      }

      $routeDifferences = array_diff($routeParts, $urlParts);

      foreach($routeDifferences as $key => $value) {
        if(substr($value, 0, 1) !== ':') {
          continue;
        } 

        $params[substr($value, 1)] = $urlParts[$key];
      }

      if(count($params) === count($routeDifferences)) {
        return [Response::OK, $route, $params];
      } else {
        $params = [];
      }
    }

    $params['url'] = $uri;

    return [Response::NOT_FOUND, $this->error(Route::ERROR_404), $params];
  }

  private function error($errorCode) {
    return $this->getRouteByName($errorCode);
  }
}