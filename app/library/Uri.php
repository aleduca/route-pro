<?php

namespace app\library;

class Uri
{

  public function __construct(private string $uri)
  {
  }

  public function getUri()
  {
    return $this->uri;
  }

  public function setUri(string $uri)
  {
    $this->uri = $uri;
  }

  public function currentUri()
  {
    return $_SERVER['REQUEST_URI'] !== '/' ? rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') : '/';
  }

  public function currentRequest()
  {
    return strtolower($_SERVER['REQUEST_METHOD']);
  }
}
