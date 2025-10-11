<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('Admin', function (RouteCollection $routes) {
  $routes->get('/', 'AdminController::index');

  $routes->get('kategori-artikel', 'ArtikelController::index');
  $routes->get('kategori-artikel/create', 'ArtikelController::create');
  $routes->post('kategori-artikel/store', 'ArtikelController::store');
  $routes->get('kategori-artikel/(:num)/edit', 'ArtikelController::edit/$1');
  $routes->post('kategori-artikel/(:num)/update', 'ArtikelController::update/$1');
  $routes->post('kategori-artikel/(:num)/delete', 'ArtikelController::delete/$1');
});
