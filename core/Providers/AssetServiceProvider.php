<?php

namespace Core\Providers;

use Core\Service\ServiceProvider;
use Core\Asset\AssetHelper;

class AssetServiceProvider extends ServiceProvider {

  public function register() {
    $serverType = $this->app->getServerType();
    $assetRootConfig = $this->app->config('asset_root');

    $assetBaseUrl = $assetRootConfig['default'];

    if(isset($assetRootConfig[$serverType])) {
      $assetBaseUrl = $assetRootConfig[$serverType];
    }

    $this->registerServicesSingleton([
      'assethelper' => function() use (&$assetBaseUrl) {
        return new AssetHelper($assetBaseUrl);
      }
    ]);
  }
}