<?php 

namespace App\Controllers\Load;

use App\Services\Load\LoadSearcherService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class LoadsGetController extends ResourceController {
    private LoadSearcherService $loadSearcherService;

    public function __construct() {
        $this->loadSearcherService = new LoadSearcherService();
    }

    public function do(): ResponseInterface 
    {
        $loads = $this->loadSearcherService->search();

        $data = array_map(function ($load) {
            return [
                'id'         => $load->getId(),
                'type'       => $load->getType(),
                'name'       => $load->getName(),
                'commission' => $load->getCommission(),
            ];
        }, $loads);

        return $this->response->setJSON($data);
    }
}
