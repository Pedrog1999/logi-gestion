<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');

$routes->setAutoRoute(false);

// Ruta de test que ya tenías
$routes->get('api/test', 'Api\TestController::index');

// Home
$routes->get('/', 'Home::index');

// ---------- API ----------
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function (RouteCollection $routes) {

    // Preflight CORS (el filtro 'cors' responde antes de llegar acá)
    $routes->options('(:any)', static function () {
    });

    // Público
    $routes->post('auth/login', 'AuthController::login', ['filter' => 'throttle']);

    // Autenticado
    $routes->get('auth/me', 'AuthController::me', ['filter' => 'auth']);

    // Solo admin (el orden importa: primero auth, después admin)
    $routes->group('users', static function (RouteCollection $routes) {
        // Lectura: cualquier autenticado
        $routes->get('', 'UserController::index', ['filter' => 'auth']);
        $routes->get('(:num)', 'UserController::show/$1', ['filter' => 'auth']);

        // Escritura: solo admin
        $routes->post('', 'UserController::create', ['filter' => ['auth', 'admin']]);
        $routes->patch('(:num)', 'UserController::update/$1', ['filter' => ['auth', 'admin']]);
        $routes->delete('(:num)', 'UserController::deactivate/$1', ['filter' => ['auth', 'admin']]);
        $routes->patch('(:num)/activate', 'UserController::activate/$1', ['filter' => ['auth', 'admin']]);

        
    });
        // ---- Drivers ----
        $routes->group('drivers', function ($routes) {
            $routes->get('', 'Driver\DriversGetController::search');
            $routes->get('(:num)', 'Driver\DriverGetController::find/$1');
            $routes->post('', 'Driver\DriverPostController::create');
            $routes->put('(:num)', 'Driver\DriverPutController::put/$1');
            $routes->delete('(:num)', 'Driver\DriverDeleteController::do/$1');
    });
});
