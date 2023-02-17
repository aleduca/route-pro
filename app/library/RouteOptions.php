<?php

namespace App\Library;

class RouteOptions
{
  public function __construct(private readonly array $routeOptions)
  {
  }

  public function optionExist(string $index)
  {
    return !empty($this->routeOptions) && isset($this->routeOptions[$index]);
  }

  public function execute(string $index)
  {
    return $this->routeOptions[$index];
  }
}
