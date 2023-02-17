<?php

namespace app\library;

use app\library\Uri;
use Closure;

class Router
{
  private array $routes = [];
  private array $routeOptions = [];

  public function add(
    string $uri,
    string $request,
    string $controller
  ) {
    $route = new Route($request, $controller);
    $route->addRouteUri(new Uri($uri));
    $route->addRouteGroupOptions(new RouteOptions($this->routeOptions));
    $this->routes[] = $route;
  }

  public function group(array $routeOptions, Closure $callback)
  {
    $this->routeOptions = $routeOptions;
    $callback->call($this);
    $this->routeOptions = [];
  }

  public function init()
  {
    // var_dump($this->routes);
    foreach ($this->routes as $route) {
      if ($route->match()) {
        Redirect::register($route);
        return (new Controller)->call($route);
      }
    }

    return (new Controller)->call(new Route('/404', 'GET', 'NotFoundController:index'));
  }
}
