<?php

namespace Core\Service;

abstract class ServiceProvider {

  protected $app;

  public function __construct($app) {
    $this->app = $app;
  }

  abstract public function register();

  protected function registerServices($services) {
    foreach($services as $key => $value) {
      $this->app->bind($key, $value);
    }
  }

  protected function registerServicesSingleton($services) {
    foreach($services as $key => $value) {
      $this->app->singleton($key, $value);
    }
  }
}