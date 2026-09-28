<?php 

namespace App\Controllers\Load;

use App\Dto\Request\Load\LoadRequest;
use App\Services\Load\LoadCreatorService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class LoadPostController extends ResourceController {

    private LoadCreatorService $loadCreatorService;

    public function __construct() {
        $this->loadCreatorService = new LoadCreatorService();
    }

    public function do(): ResponseInterface 
    {
        $json = $this->request->getJSON(true) ?? [];

        $request = new LoadRequest(
            $json['type'] ?? '',
            $json['name'] ?? '',
            (float)($json['commission'] ?? 0)
        );

        $response = $this->loadCreatorService->create($request);

        return $this->response->setJSON([
            'id'         => $response->getId(),
            'type'       => $response->getType(),
            'name'       => $response->getName(),
            'commission' => $response->getCommission(),
        ]);   
    }
}
