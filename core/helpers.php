<?php
use Core\Templating\Template;

$cache = [];

function app($service = '') {
  global $app;

  if(!empty($service)) {
    return $app->resolve($service);
  }

  return $app;
}

function command(string $command, array $args) {
  return app()->commander->execute($command, $args);
}

function query($query, $params = []) {
  return app('database')->query($query, $params);
}

function mailTo($to, $subject, $template) {
  return app('mailer')->mail($to, $subject, $template);
}

function view($file) {
  return app_path(str_replace('.', DIRECTORY_SEPARATOR, $file)) . '.php';
}

/**
* Redirects to another location
*
* @param string $location - The location
*
* @return void
*/
function redirectTo(string $location) {
  header('Location: ' . $location);
  exit();
}

/**
* Sets the CSRF token
*
* @return void
*/
function set_csrf() {
  $_SESSION['x-token'] = md5(uniqid());
}

/**
* Returns an input field for a form with the CSRF token
*
* @return string
*/
function csrf_field(): string {
  if(!isset($_SESSION['x-token'])) {
    die('csrf not set!');
  }

  return '<input type="hidden" name="x-token" value="' . $_SESSION['x-token'] . '">';
}

function back() {
  $backUrl = app('session')->get('prevUri');

  if(!$backUrl) {
    $backUrl = '/';
  }

  if(strpos($backUrl, 'favicon') !== false) {
      $backUrl = '/';
  }

  return $backUrl;
}

function config(string $file, string $key) {
  return require config_path($file)[$key];
}

function asset(string $file): string {
  return app('assethelper')->asset($file);
}

function css(string $file): string {
  return app('assethelper')->css($file);
}

function js(string $file): string {
  return app('assethelper')->js($file);
}

function isAuthenticated() {
  if(!isset($_SESSION['user_id'])) {
    return false;
  }
  
  return $_SESSION['user_id'] !== null;
}

function user() {
  global $cache;

  if(isset($cache['user'])) {
    return $cache['user'];
  }

  $user = app('database')->query('select * from RegisteredUser where username = ?', [$_SESSION['user_id']])[0];
  $cache['user'] = $user;

  return $user;
}

function url($path = '') {
  if(is_string($path)) {
    return $_SERVER['REQUEST_URI'] . $path;
  }

  return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '?' . http_build_query($path);
}

function template(string $path, array $data = []): string {
  return Template::loadContents($path, $data);
}

require_once core_path('Routing/utils.php');
