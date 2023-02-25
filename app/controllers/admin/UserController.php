<?php

namespace App\Controllers\Admin;

class UserController
{
  public function index($userId, $userName)
  {
    var_dump($userName, $userId);
  }

  public function show($userName)
  {
    var_dump($userName);
  }
}
