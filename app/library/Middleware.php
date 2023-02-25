<?php

namespace app\library;

use app\enums\RouteMiddlewares;
use app\interfaces\MiddlewareInterface;
use Exception;

class Middleware
{

  private string $middlewareClass;

  public function __construct(protected array $middlewares)
  {
  }

  private function middlewareExist(string $middleware)
  {
    $casesMiddleware = RouteMiddlewares::cases();

    return array_filter(
      $casesMiddleware,
      function (RouteMiddlewares $middlewareCase) use ($middleware) {
        if ($middlewareCase->name === $middleware) {
          $this->middlewareClass = $middlewareCase->value;
          return true;
        }
        return false;
      }
    );
  }

  public function execute()
  {
    foreach ($this->middlewares as $middleware) {
      if (!$this->middlewareExist($middleware)) {
        throw new \Exception("Middleware {$middleware} not exist");
      }

      $class = $this->middlewareClass;
      if (!class_exists($class)) {
        throw new \Exception("Class middleware {$middleware} not exist");
      }

      $middlewareClass = new $class;

      if (!$middlewareClass instanceof MiddlewareInterface) {
        throw new \Exception("Middleware {$class} must implement MiddlewareInterface");
      }

      $middlewareClass->execute();
    }
  }
}
