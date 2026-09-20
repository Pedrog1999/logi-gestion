<?php 

namespace App\Services\Company;

use App\Converter\Company\CompanyToCompanyResponseConverter;
use App\Dto\Request\Company\CompanyRequest;
use App\Dto\Response\Company\CompanyResponse;
use App\Models\CompanyModel;

final class CompanyUpdaterService {

    private CompanyModel $companyModel;
    private CompanyFinderService $companyFinderService;
    private CompanyToCompanyResponseConverter $converter;

    public function __construct() {
        $this->companyModel = new CompanyModel();
        $this->companyFinderService = new CompanyFinderService();
        $this->converter = new CompanyToCompanyResponseConverter();
    }

    public function update(CompanyRequest $request, int $id): CompanyResponse
    {
        $company = $this->companyFinderService->find($id);

        $company->update($request);

        $company = $this->companyModel->update($company);

        $response = $this->converter->convert($company);

        return $response;
    }
}