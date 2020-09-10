<?php

namespace Core\Providers;

use Provider\ServiceProvider;
use Core\App;

class AppProvider {

  public static function createApp(string $serverType) {
    $app = new App($serverType);
    
    $serviceProvider = new ServiceProvider();
    $serviceProvider->registerServices($app);

    return $app;
  }
}