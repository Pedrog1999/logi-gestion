<?php 

namespace App\Controllers\Load;

use App\Services\Load\LoadDeleterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class LoadDeleteController extends ResourceController {
    private LoadDeleterService $loadDeleterService;

    public function __construct() {
        $this->loadDeleterService = new LoadDeleterService();
    }

    public function do(int $id): ResponseInterface 
    {
        $this->loadDeleterService->delete($id);

        return $this->response->setJSON([
            'id' => $id
        ]);
    }
}
