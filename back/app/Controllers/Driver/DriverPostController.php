<?php 

namespace App\Controllers\Driver;

use App\Dto\Request\Driver\DriverRequest;
use App\Services\Driver\DriverCreatorService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class DriverPostController extends ResourceController {

    private DriverCreatorService $driverCreatorService;

    public function __construct() {
        $this->driverCreatorService = new DriverCreatorService();
    }

    public function create(): ResponseInterface
    {
        $driverRequest = $this->getRequest();

        $driverResponse = $this->driverCreatorService->create($driverRequest);

        return $this->response->setJSON($driverResponse);
    }

    private function getRequest(): DriverRequest
    {
        $parameters = $this->request->getJson();

        return new DriverRequest(
            $parameters->name,
            $parameters->surname,
            $parameters->cuil,
            $parameters->phone,
            $parameters->email,
            $parameters->status
        );
    }
}