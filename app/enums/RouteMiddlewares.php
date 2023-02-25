<?php

namespace app\enums;

use app\middlewares\Auth;
use app\middlewares\Teste;

enum RouteMiddlewares: string
{
  case auth = Auth::class;
  case teste = Teste::class;
}
