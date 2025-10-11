<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('Admin', function (RouteCollection $routes) {
  $routes->get('/', 'AdminController::index');
});
