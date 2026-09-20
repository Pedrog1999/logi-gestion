<?php 

namespace App\Controllers\Company;

use App\Dto\Request\Company\CompanyRequest;
use App\Services\Company\CompanyCreatorService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class CompanyPostController extends ResourceController {

    private CompanyCreatorService $companyCreatorService;

    public function __construct() {
        $this->companyCreatorService = new CompanyCreatorService();
    }

    public function create(): ResponseInterface
    {
        $companyRequest = $this->getRequest();

        $companyResponse = $this->companyCreatorService->create($companyRequest);

        return $this->response->setJSON($companyResponse);
    }

    private function getRequest(): CompanyRequest
    {
        $parameters = $this->request->getJson();

        return new CompanyRequest(
            $parameters->businessName,
            $parameters->cuit,
            $parameters->phone,
            $parameters->email,
            $parameters->address
        );
    }
}