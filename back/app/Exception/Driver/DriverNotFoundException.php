<?php 

namespace App\Exception\Driver;

use Exception;

class DriverNotFoundException extends Exception {
    public function __construct(int $id) {
        parent::__construct("No se encontro el driver con id: $id", 404);
    }
}