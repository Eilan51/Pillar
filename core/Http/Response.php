<?php

namespace Core\Http;

use Core\Templating\Template;

class Response {

  public const OK = 200;
  public const REDIRECT = 302;
  public const NOT_FOUND = 404;
  public const UNAUTHORIZED = 403;
  public const INTERNAL_SERVER_ERROR = 500;

  private $code;
  private $file;
  private $redirect;

  private $viewData = [];

  public function __construct($code, $file, $redirect = false) {
    $this->code = $code;
    $this->file = $file;
    $this->redirect = $redirect;
  }

  public function setViewData($data) {
    $this->viewData = $data;
  }

  public static function error(int $error, string $message = null) {
    $route = app()->router->getRouteByName($error);

    $response = new self($error, $route->getDestination());

    if($message) {
      $response->setViewData([
        'message' => $message
      ]);
    }

    return $response;
  }

  public static function redirect(string $route) {
    return new self(self::REDIRECT, null, $route);
  }

  public function send() {
    http_response_code($this->code);

    if($this->redirect) {
      redirectTo($this->redirect);
    }

    foreach($this->viewData as $key => $value) {
      $$key = $value;
    }

    require_once $this->file;
  }
}