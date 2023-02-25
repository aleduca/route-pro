<?php

namespace app\middlewares;

use app\interfaces\MiddlewareInterface;
use app\library\Auth as LibraryAuth;
use app\library\Redirect;

class Auth implements MiddlewareInterface
{
  public function execute()
  {
    if (!LibraryAuth::isAuth()) {
      return Redirect::to('/');
    }
  }
}
