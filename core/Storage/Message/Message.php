<?php

namespace Core\Storage\Message;

class Message {

  public const NOTICE = 'notice';
  public const WARNING = 'error';

  private $type;
  private $content;

  public function __construct($type, $content) {
    $this->type = $type;
    $this->content = $content;
  }

  public function getType() {
    return $this->type;
  }

  public function getContent() {
    return $this->content;
  }
}