<?php

namespace Core\Command;

use Core\Command\ServeCommand;

class Commander {

  private $commands = [
    'serve' => ServeCommand::class
  ];

  public function execute(string $command, array $args) {
    $command = new $this->commands[$command];
    $command->execute($args);
  }
}