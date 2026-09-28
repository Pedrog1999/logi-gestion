<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');

// Ruta principal
$routes->get('/', 'Home::index');

// Rutas de prueba
$routes->get('api/test', 'Api\TestController::index');

// Rutas de drivers
$routes->group('api', function ($routes) {
    $routes->get('drivers', 'Api\DriversController::index');
    $routes->get('drivers/(:num)', 'Api\DriversController::show/$1');
    $routes->post('drivers', 'Api\DriversController::create');
    $routes->put('drivers/(:num)', 'Api\DriversController::update/$1');
    $routes->delete('drivers/(:num)', 'Api\DriversController::delete/$1');
});