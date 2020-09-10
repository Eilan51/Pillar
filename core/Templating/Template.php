<?php

namespace Core\Templating;

use Exception;

class Template {

  private $path;
  private $data = [];
  private $contents;
  private $loaded = false;

  public function __construct(string $path, array $data = []) {
    $this->path = $path;
    $this->data = $data;
  }

  public static function loadContents(string $path, array $data = []): string {
    $template = new self($path, $data);
    $template->load();

    return $template->getContents();
  }

  public function load() {
    ob_start();

    foreach($this->data as $key => $value) {
      $$key = $value;
    }

    // Load template
    if(!file_exists($this->path)) {
      throw new Exception('No template found at: ' . $this->path);
    }

    require $this->path;

    $contents = ob_get_contents();

    // Clean buffer
    ob_end_clean();

    $this->contents = $contents;
    $this->loaded = true;
  }

  public function loaded() {
    return $this->loaded;
  }

  public function getContents() {
    return $this->contents;
  }
}