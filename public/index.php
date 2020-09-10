<?php

require_once '../core/index.php';

$uri = urldecode(
  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

session_start();

$response = app()->router->handleRequest($uri, app('request'));
$response->send();

app('database')->close();
app('session')->set('prevUri', $uri);
app('message')->clear();