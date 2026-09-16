<?php 

namespace App\Controllers\Driver;

use App\Dto\Request\Driver\DriverFilterRequest;
use App\Dto\Request\PaginationRequest;
use App\Services\Driver\DriversSearcherService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

final class DriversGetController extends ResourceController {

    private DriversSearcherService $driversSearcherService;

    public function __construct() {
        $this->driversSearcherService = new DriversSearcherService();
    }

    public function search(): ResponseInterface
    {
        $request = $this->getRequest();

        $responses = $this->driversSearcherService->searchResponses($request);

        return $this->response->setJSON($responses);
    }

    private function getRequest(): DriverFilterRequest
    {
        $request = $this->request->getJSON();

        return new DriverFilterRequest(
            new PaginationRequest(
                $request->page ?? 1,
                $request->size ?? 10
            ),
            $request->name ?? null,
            $request->surname ?? null,
            $request->cuil ?? null,
            $request->email ?? null,
            $request->status ?? null
        );
    }
}