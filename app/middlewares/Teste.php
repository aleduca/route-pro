<?php

namespace app\middlewares;

use app\interfaces\MiddlewareInterface;

class Teste implements MiddlewareInterface
{
  public function execute()
  {
    var_dump('execute teste middleware');
  }
}
