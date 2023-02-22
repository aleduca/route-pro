<?php

try {
  $router->group(['prefix' => 'admin', 'controller' => 'admin', 'middlewares' => []], function () {
    $this->add('/', 'GET', 'AdminController:index');
    $this->add('/user/(:alpha)', 'GET', 'UserController:show');
    $this->add('/user/(:numeric)/name/(:alpha)', 'GET', 'UserController:index', ['userId', 'userName']);
  });

  $router->add('/', 'GET', 'HomeController:index');
  $router->add('/cart', 'GET', 'CartController:index');
  $router->add('/product/(:numeric)/name/(:alpha)', 'GET', 'ProductController:index');
  $router->add('/product/(:alpha)', 'GET', 'ProductController:index');
  $router->add('/cart/add', 'GET', 'CartController:add');
  $router->add('/cart/remove', 'GET', 'CartController:destroy');
  $router->add('/cart/update', 'POST', 'CartController:update');
  $router->add('/login', 'GET', 'LoginController:index');
  $router->add('/login', 'POST', 'LoginController:store');
  $router->add('/logout', 'GET', 'LoginController:destroy');
  $router->add('/checkout', 'GET', 'CheckoutController:checkout');
  $router->add('/success', 'GET', 'StatusCheckoutController:success');
  $router->add('/cancel', 'GET', 'StatusCheckoutController:cancel');
  $router->add('/webhook', 'GET', 'WebhookController:payment');
  $router->init();
} catch (Exception $e) {
  var_dump($e->getMessage() . ' ' . $e->getFile() . ' ' . $e->getLine());
}
