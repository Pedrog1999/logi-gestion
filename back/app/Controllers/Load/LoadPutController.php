<?php 

namespace App\Controllers\Load;

use App\Dto\Request\Load\LoadRequest;
use App\Services\Load\LoadUpdaterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class LoadPutController extends ResourceController {

    private LoadUpdaterService $loadUpdaterService;

    public function __construct() {
        $this->loadUpdaterService = new LoadUpdaterService();
    }

    public function do(int $id): ResponseInterface 
    {
        $json = $this->request->getJSON(true) ?? [];

        $request = new LoadRequest(
            $json['type'] ?? '',
            $json['name'] ?? '',
            (float)($json['commission'] ?? 0)
        );

        $response = $this->loadUpdaterService->update($request, $id);

        return $this->response->setJSON([
            'id'         => $response->getId(),
            'type'       => $response->getType(),
            'name'       => $response->getName(),
            'commission' => $response->getCommission(),
        ]);   
    }
}
