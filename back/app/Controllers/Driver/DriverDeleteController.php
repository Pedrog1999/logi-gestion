<?php 

namespace App\Controllers\Driver;

use App\Services\Driver\DriverDeleterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class DriverDeleteController extends ResourceController {

    private DriverDeleterService $driverDeleterService;

    public function __construct() {
        $this->driverDeleterService = new DriverDeleterService();
    }

    public function do(int $id): ResponseInterface
    {
        $this->driverDeleterService->delete($id);

        return $this->response->setJSON([
            "id" => $id
        ]);
    }
}