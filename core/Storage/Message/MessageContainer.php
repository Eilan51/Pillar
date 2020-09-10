<?php

namespace Core\Storage\Message;

use Core\Storage\Message\Message;

class MessageContainer {

  private $messages = [];

  public function __construct() {
    $this->init();
  }

  public function init() {
    $messages = $_SESSION['messages'] ?? [];

    foreach($messages as $message) {
      $this->messages[] = new Message($message[0], $message[1]);
    }
  }

  public function hasMessages(): bool {
    return count($this->messages) > 0;
  }

  public function getMessages() {
    return $this->messages;
  }

  public function send($type, $content) {
    $_SESSION['messages'][] = [$type, $content];

    $this->messages[] = new Message($type, $content);
  }

  public function notice($content) {
    $this->send(Message::NOTICE, $content);
  }

  public function warning($content) {
    $this->send(Message::WARNING, $content);
  }

  public function clear() {
    $this->messages = [];
    $_SESSION['messages'] = [];
  }
}