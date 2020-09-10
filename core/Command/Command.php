<?php

namespace Core\Command;

interface Command {
  public function execute(array $args);
}