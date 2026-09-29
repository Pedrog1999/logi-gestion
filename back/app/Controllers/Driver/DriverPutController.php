<?php 

namespace App\Controllers\Driver;

use App\Dto\Request\Driver\DriverRequest;
use App\Services\Driver\DriverUpdaterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class DriverPutController extends ResourceController {

    private DriverUpdaterService $driverUpdaterService;

    public function __construct() {
        $this->driverUpdaterService = new DriverUpdaterService();
    }

    public function put(int $id): ResponseInterface
    {
        $request = $this->getRequest();

        $response = $this->driverUpdaterService->update($request, $id);

        return $this->response->setJSON($response);
    }

    private function getRequest(): DriverRequest
    {
        $request = $this->request->getJSON();

        return new DriverRequest(
            $request->name,
            $request->surname,
            $request->cuil,
            $request->phone,
            $request->email,
            $request->status
        );
    }
}