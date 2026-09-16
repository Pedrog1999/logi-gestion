<?php 

namespace App\Controllers\Driver;

use App\Services\Driver\DriverFinderService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class DriverGetController extends ResourceController {

    private DriverFinderService $driverFinderService;

    public function __construct() {
        $this->driverFinderService = new DriverFinderService();
    }

    public function find(int $id): ResponseInterface
    {
        $driver = $this->driverFinderService->findResponse($id);

        return $this->response->setJSON($driver);
    }
}