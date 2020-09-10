<?php
/**
* Returns a route by it's name
*
* @param string $name
*
* @param bool $fullObject
*
* @return Route
*/
function route(string $name, $params = []) {
  $route = app()->router->getRouteByName($name);

  return $route->getUrl();
}
