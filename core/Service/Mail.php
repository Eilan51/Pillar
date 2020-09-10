<?php

namespace Core\Service;

class Mail {

  private $to;
  private $from;
  private $subject;
  private $template;
  private $data;

  public function __construct($to, $subject, $template, $data = []) {
    $this->to = $to;
    $this->from = app()->config('mail_from');
    $this->subject = $subject;
    $this->template = $template;
    $this->data = $data;
  }

  public function data($data = []) {
    $this->data = $data;

    return $this;
  }

  public function inspect() {
    return $this->getBody();
  }

  public function send() {
    return mail($this->to, $this->subject, $this->getBody(), $this->getHeaders());
  }

  private function getHeaders() {
    return join("\n", [
      'From: ' . $this->from,
      'Content-Type: text/html; charset=ISO-8859-1' . "\r\n"
    ]);
  }

  private function getBody(): string {
    foreach($this->data as $key => $value) {
      $$key = $value;
    }

    ob_start();

    require $this->template;
    $content = ob_get_contents();

    ob_end_clean();

    return $content;
  }
}