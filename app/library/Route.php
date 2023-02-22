<?php

namespace app\library;

use App\Library\RouteOptions;
use App\Library\Uri;

class Route
{
  private ?RouteOptions $routeOptions = null;
  private ?Uri $uri = null;
  private ?RouteWildcard $routeWildcard = null;

  public function __construct(
    public readonly string $request,
    public readonly string $controller,
    public readonly array $wildcardAliases,
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

  public function addRouteWildcard(RouteWildcard $routeWildcard)
  {
    $this->routeWildcard = $routeWildcard;
  }

  public function getRouteWildcardInstance(): ?RouteWildcard
  {
    return $this->routeWildcard;
  }


  public function match()
  {

    if ($this->routeOptions->optionExist('prefix')) {
      $this->uri->setUri(rtrim("/{$this->routeOptions->execute('prefix')}{$this->uri->getUri()}", '/'));
    }

    $this->routeWildcard->replaceWildcardWithPattern($this->uri->getUri());
    $wildcardReplaced = $this->routeWildcard->getWildcardReplaced();

    if ($wildcardReplaced !== $this->uri->getUri() && $this->routeWildcard->uriEqualToPattern($this->uri->currentUri(), $wildcardReplaced)) {
      $this->uri->setUri($this->uri->currentUri());
      $this->routeWildcard->paramsToArray($this->uri->getUri(), $wildcardReplaced, $this->wildcardAliases);
    }

    if (
      $this->uri->getUri() === $this->uri->currentUri() &&
      strtolower($this->request) === $this->uri->currentRequest()
    ) {
      return $this;
    }
  }
}
