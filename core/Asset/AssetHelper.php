<?php

namespace Core\Asset;

class AssetHelper {

  private $baseUrl;

  public function __construct(string $baseUrl) {
    $this->baseUrl = $baseUrl;
  }

  public function asset(string $file): string {
    return $this->baseUrl . $file;
  }

  public function css(string $path): string {
    return $this->asset($path . '.css');
  }

  public function js(string $path): string {
    return $this->asset($path . '.js');
  }
}