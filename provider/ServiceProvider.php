<?php

namespace Provider;

use Core\Providers\Http\RequestServiceProvider;
use Core\Providers\StorageServiceProvider;
use Core\Providers\AssetServiceProvider;
use Core\Providers\MailerServiceProvider;

class ServiceProvider {

  private $providers = [
    StorageServiceProvider::class,
    RequestServiceProvider::class,
    AssetServiceProvider::class,
    MailerServiceProvider::class
  ];

  public function registerServices($app) {
    foreach ($this->providers as $provider) {
      (new $provider($app))->register();
    }
  }
}