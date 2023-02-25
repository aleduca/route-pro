<?php

namespace app\middlewares;

use App\Interfaces\MiddlewareInterface;

class Teste implements MiddlewareInterface
{
  public function execute()
  {
    var_dump('execute teste middleware');
  }
}
