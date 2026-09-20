<?php 

namespace App\Controllers\Company;

use App\Services\Company\CompanyDeleterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class CompanyDeleteController extends ResourceController {

    private CompanyDeleterService $companyDeleterService;

    public function __construct() {
        $this->companyDeleterService = new CompanyDeleterService();
    }

    public function do(int $id): ResponseInterface
    {
        $this->companyDeleterService->delete($id);

        return $this->response->setJSON([
            "id" => $id
        ]);
    }
}