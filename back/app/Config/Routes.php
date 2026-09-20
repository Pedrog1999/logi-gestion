<?php namespace Config; $routes = Services::routes(); $routes->setDefaultNamespace('App\Controllers'); $routes->setDefaultController('Home'); $routes->setDefaultMethod('index'); $routes->get('api/test', 'Api\TestController::index'); $routes->get('/', 'Home::index');

$routes->group('api', function ($routes) {

    // drivers
    $routes->group('drivers', function ($routes) {
        $routes->get('', 'Driver\DriversGetController::search');
        $routes->get('(:num)', 'Driver\DriverGetController::find/$1');
        $routes->post('', 'Driver\DriverPostController::create');
        $routes->put('(:num)', 'Driver\DriverPutController::put/$1');
        $routes->delete('(:num)', 'Driver\DriverDeleteController::do/$1');
    });

    // companies
    $routes->group('companies', function ($routes) {
        $routes->get('', 'Company\CompaniesGetController::search');
        $routes->get('(:num)', 'Company\CompanyGetController::find/$1');
        $routes->post('', 'Company\CompanyPostController::create');
        $routes->put('(:num)', 'Company\CompanyPutController::put/$1');
        $routes->delete('(:num)', 'Company\CompanyDeleteController::do/$1');
    });

});