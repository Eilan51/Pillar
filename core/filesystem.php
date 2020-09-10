<?php
/**
* Returns a path with the correct directory separator and entry point
*
* @param string $base
*
* @param string $path
*
* @return string
*/
function file_path(string $base, string $path = ''): string {
  $filePath = str_replace('core', '', __DIR__) . "$base/" . $path;

  return preg_replace('/\/|\\+/', DIRECTORY_SEPARATOR, $filePath);
}

function project_path(string $path = '') {
  return realpath('../') . DIRECTORY_SEPARATOR . $path;
}

/**
* Returns the path to the app directory
*
* @return string
*/
function app_path($path = ''): string {
  return file_path('app', $path);
}

/**
* Returns the path to the config directory
*
* @return string
*/
function config_path($path = ''): string {
  return file_path('config', $path);
}

/**
* Returns the path to the app directory
*
* @return string
*/
function core_path($path = '') {
  return file_path('core', $path);
}

/**
* Returns the path to the public directory
*
* @return string
*/
function public_path($path = '') {
  return file_path('public', $path);
}

/**
* Returns the path to the public's js directory
*
* @return string
*/
function js_path(string $path): string {
  return "/js/$path.js";
}

/**
* Returns the path to the public's css directory
*
* @return string
*/
function css_path(string $path): string {
  return "/css/$path.css";
}

/**
* Returns the file path with the correct PHP file extension
*
* @param string $path - The path
*
* @return string
*/
function php_file(string $path): string {
  return $path . '.php';
}

// $customPaths = require_once config_path('filesystem.php');

/**
* Returns a custom set path
*
* @param string $path - The key set for the path
*
* @return string
*/
function path(string $path): string {
  global $customPaths;

  if(array_key_exists($path, $customPaths)) {
    return $customPaths[$path];
  }

  return null;
}

function database_config(): array {
  return require config_path('database.php');
}

