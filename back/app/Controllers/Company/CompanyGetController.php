<?php 

namespace App\Controllers\Company;

use App\Services\Company\CompanyFinderService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class CompanyGetController extends ResourceController {

    private CompanyFinderService $companyFinderService;

    public function __construct() {
        $this->companyFinderService = new CompanyFinderService();
    }

    public function find(int $id): ResponseInterface
    {
        $company = $this->companyFinderService->findResponse($id);

        return $this->response->setJSON($company);
    }
}