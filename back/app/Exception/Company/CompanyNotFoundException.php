<?php 

namespace App\Exception\Company;

use Exception;

class CompanyNotFoundException extends Exception {
    public function __construct(int $id) {
        parent::__construct("No se encontro la company con id: $id", 404);
    }
}