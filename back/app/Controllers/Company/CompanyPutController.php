<?php 

namespace App\Controllers\Company;

use App\Dto\Request\Company\CompanyRequest;
use App\Services\Company\CompanyUpdaterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class CompanyPutController extends ResourceController {

    private CompanyUpdaterService $companyUpdaterService;

    public function __construct() {
        $this->companyUpdaterService = new CompanyUpdaterService();
    }

    public function put(int $id): ResponseInterface
    {
        $request = $this->getRequest();

        $response = $this->companyUpdaterService->update($request, $id);

        return $this->response->setJSON($response);
    }

    private function getRequest(): CompanyRequest
    {
        $request = $this->request->getJson();

        return new CompanyRequest(
            $request->businessName,
            $request->cuit,
            $request->phone,
            $request->email,
            $request->address
        );
    }
}