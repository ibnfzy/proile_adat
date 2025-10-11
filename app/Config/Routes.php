<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/galeri', 'GaleriController::publicIndex');

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

  // Informasi
  $routes->get('informasi', 'InformasiController::index');
  $routes->get('informasi/create', 'InformasiController::create');
  $routes->post('informasi/store', 'InformasiController::store');
  $routes->get('informasi/(:num)', 'InformasiController::show/$1');
  $routes->get('informasi/(:num)/edit', 'InformasiController::edit/$1');
  $routes->post('informasi/(:num)/update', 'InformasiController::update/$1');
  $routes->post('informasi/(:num)/delete', 'InformasiController::delete/$1');

  // Galeri
  $routes->get('galeri', 'GaleriController::index');
  $routes->get('galeri/create', 'GaleriController::create');
  $routes->post('galeri/store', 'GaleriController::store');
  $routes->get('galeri/(:num)/edit', 'GaleriController::edit/$1');
  $routes->post('galeri/(:num)/update', 'GaleriController::update/$1');
  $routes->post('galeri/(:num)/delete', 'GaleriController::delete/$1');
});
