<?php

namespace Core\Providers;

use Core\Service\ServiceProvider;

use Core\Storage\Database;
use Core\Storage\Session\SessionHelper;
use Core\Storage\Cookie\CookieHelper;
use Core\Storage\Message\MessageContainer;

class StorageServiceProvider extends ServiceProvider {

  public function register() {
    $this->registerServicesSingleton([
      'database' => function() {
        return new Database();
      },
    ]);

    $this->registerServices([
      'session' => function() {
        return new SessionHelper();
      },

      'cookie' => function() {
        return new CookieHelper();
      },

      'message' => function() {
        return new MessageContainer();
      },
    ]);
  }
}