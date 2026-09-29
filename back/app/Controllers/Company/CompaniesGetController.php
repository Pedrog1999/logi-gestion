<?php 

namespace App\Controllers\Company;

use App\Dto\Request\Company\CompanyFilterRequest;
use App\Dto\Request\PaginationRequest;
use App\Services\Company\CompaniesSearcherService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

final class CompaniesGetController extends ResourceController {

    private CompaniesSearcherService $companiesSearcherService;

    public function __construct() {
        $this->companiesSearcherService = new CompaniesSearcherService();
    }

    public function search(): ResponseInterface
    {
        $request = $this->getRequest();

        $responses = $this->companiesSearcherService->searchResponses($request);

        return $this->response->setJSON($responses);
    }

    private function getRequest(): CompanyFilterRequest
    {
        $request = $this->request->getJson();

        return new CompanyFilterRequest(
            new PaginationRequest(
                $request->page ?? 1,
                $request->size ?? 10
            ),
            $request->businessName ?? null,
            $request->cuit ?? null,
            $request->email ?? null,
            $request->address ?? null
        );
    }
}