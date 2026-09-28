<?php 

namespace App\Controllers\Load;

use App\Services\Load\LoadFinderService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class LoadGetController extends ResourceController {
    private LoadFinderService $loadFinderService;

    public function __construct() {
        $this->loadFinderService = new LoadFinderService();
    }

    public function do(int $id): ResponseInterface 
    {
        $response = $this->loadFinderService->findResponse($id);

        return $this->response->setJSON([
            'id'         => $response->getId(),
            'type'       => $response->getType(),
            'name'       => $response->getName(),
            'commission' => $response->getCommission(),
        ]);
    }
}
