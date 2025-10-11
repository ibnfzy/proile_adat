<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('Admin', function (RouteCollection $routes) {
  $routes->get('/', 'AdminController::index');

  // Kategori Artikel
  $routes->get('kategori-artikel', 'KategoriArtikelController::index');
  $routes->get('kategori-artikel/create', 'KategoriArtikelController::create');
  $routes->post('kategori-artikel/store', 'KategoriArtikelController::store');
  $routes->get('kategori-artikel/(:num)/edit', 'KategoriArtikelController::edit/$1');
  $routes->post('kategori-artikel/(:num)/update', 'KategoriArtikelController::update/$1');
  $routes->post('kategori-artikel/(:num)/delete', 'KategoriArtikelController::delete/$1');

  // Artikel
  $routes->get('artikel', 'ArtikelController::index');
  $routes->get('artikel/create', 'ArtikelController::create');
  $routes->post('artikel/store', 'ArtikelController::store');
  $routes->get('artikel/(:num)', 'ArtikelController::show/$1');
  $routes->get('artikel/(:num)/edit', 'ArtikelController::edit/$1');
  $routes->post('artikel/(:num)/update', 'ArtikelController::update/$1');
  $routes->post('artikel/(:num)/delete', 'ArtikelController::delete/$1');
});
