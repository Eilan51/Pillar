<?php

namespace Core\Providers;

use Core\Service\ServiceProvider;
use Core\Service\Mailer;

class MailerServiceProvider extends ServiceProvider {

  public function register() {
    $this->registerServicesSingleton([
      'mailer' => function() {
        return new Mailer();
      }
    ]);
  }
}