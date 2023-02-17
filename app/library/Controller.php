<?php

namespace app\library;

use Exception;

class Controller
{

  private function controllerPath($route, $controller)
  {
    return ($route->getRouteOptionsInstance() && $route->getRouteOptionsInstance()->optionExist('controller')) ?
      "app\\controllers\\" . $route->getRouteOptionsInstance()->execute('controller') . '\\' . $controller :
      $controllerInstance = "app\\controllers\\" . $controller;
  }


  public function call(Route $route)
  {
    $controller = $route->controller;

    if (!str_contains($controller, ':')) {
      throw new Exception("Semi colon need to controller {$controller} in route");
    }

    [$controller, $action] = explode(':', $controller);

    $controllerInstance = $this->controllerPath($route, $controller);

    if (!class_exists($controllerInstance)) {
      throw new Exception("Controller {$controller} does not exist");
    }

    $controller = new $controllerInstance;

    if (!method_exists($controller, $action)) {
      throw new Exception("Action {$action} does not exist");
    }
    call_user_func_array([$controller, $action], []);
  }
}