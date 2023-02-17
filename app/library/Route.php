<?php

namespace app\library;

use App\Library\RouteOptions;
use App\Library\Uri;

class Route
{
  private ?RouteOptions $routeOptions = null;
  private ?Uri $uri = null;

  public function __construct(
    public string $request,
    public string $controller,
  ) {
  }

  public function addRouteGroupOptions(RouteOptions $routeOptions)
  {
    $this->routeOptions = $routeOptions;
  }

  public function getRouteOptionsInstance(): ?RouteOptions
  {
    return $this->routeOptions;
  }

  public function addRouteUri(Uri $uri)
  {
    $this->uri = $uri;
  }

  public function getRouteUriInstance(): ?Uri
  {
    return $this->uri;
  }

  public function match()
  {

    if ($this->routeOptions->optionExist('prefix')) {
      $this->uri->setUri(rtrim("/{$this->routeOptions->execute('prefix')}{$this->uri->getUri()}", '/'));
    }

    if (
      $this->uri->getUri() === $this->uri->currentUri() &&
      strtolower($this->request) === $this->uri->currentRequest()
    ) {
      return $this;
    }
  }
}
