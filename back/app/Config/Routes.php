<?php namespace Config; $routes = Services::routes(); $routes->setDefaultNamespace('App\Controllers'); $routes->setDefaultController('Home'); $routes->setDefaultMethod('index'); $routes->get('api/test', 'Api\TestController::index'); $routes->get('/', 'Home::index');
// ==============================
// Rutas de la API LogiGestion
// ==============================

$routes->group('api', function ($routes) {

    // ---- Drivers ----
    $routes->group('drivers', function ($routes) {
        $routes->get('', 'Driver\DriversGetController::search');
        $routes->get('(:num)', 'Driver\DriverGetController::find/$1');
        $routes->post('', 'Driver\DriverPostController::create');
        $routes->put('(:num)', 'Driver\DriverPutController::put/$1');
        $routes->delete('(:num)', 'Driver\DriverDeleteController::do/$1');
    });

});