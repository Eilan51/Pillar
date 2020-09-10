<?php

namespace Core\Service;

use Core\Service\Mail;

class Mailer {

  private $queue = [];

  public function mail($to, $subject, $template) {
    return new Mail($to, $subject, view($template));
  }

  public function sendAll() {
    foreach($this->$queue as $queuedEmail) {
      $queuedEmail->send();
    }
  }

  public function queue(Mail $mail) {
    $this->$queue[] = $mail;
  }
}