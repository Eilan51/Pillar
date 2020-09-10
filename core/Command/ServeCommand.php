<?php

namespace Core\Command;

use Core\Command\Command;

class ServeCommand implements Command {

  private $defaultPort = 2001;

  public function execute($args) {
    $port = $args['port'] ?? $this->defaultPort;

    echo 'Server running on: http://localhost:' . $port . "\n";

    shell_exec('php -S localhost:' . $port . ' -t ' . public_path());
  }
}