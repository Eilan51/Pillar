<?php

namespace Core\Providers\Http;

use Core\Service\ServiceProvider;
use Core\Http\Request;

class RequestServiceProvider extends ServiceProvider {

  public function register() {
    $this->registerServices([
      'request' => function() {
        return new Request();
      },
    ]);
  }
}