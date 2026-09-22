<?php

namespace Config;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');

$routes->get('/', 'Home::index');
$routes->get('api/test', 'Api\TestController::index');

// Rutas REST para el módulo Load
$routes->group('api', function ($routes) {
    $routes->post('load', 'Load\LoadPostController::do');
    $routes->get('loads', 'Load\LoadsGetController::do');
    $routes->get('load/(:num)', 'Load\LoadGetController::do/$1');
    $routes->put('load/(:num)', 'Load\LoadPutController::do/$1');
    $routes->delete('load/(:num)', 'Load\LoadDeleteController::do/$1');
});
