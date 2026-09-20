<?php 

namespace App\Services\Company;

use App\Converter\Company\CompanyToCompanyResponseConverter;
use App\Dto\Request\Company\CompanyRequest;
use App\Dto\Response\Company\CompanyResponse;
use App\Entity\Company\Company;
use App\Models\CompanyModel;

final class CompanyCreatorService {

    private CompanyModel $companyModel;
    private CompanyToCompanyResponseConverter $converter;

    public function __construct() {
        $this->companyModel = new CompanyModel();
        $this->converter = new CompanyToCompanyResponseConverter();
    }

    public function create(CompanyRequest $request): CompanyResponse
    {
        $company = Company::convertFromRequest($request);

        $newCompany = $this->companyModel->insert($company);

        $companyResponse = $this->converter->convert($newCompany);

        return $companyResponse;
    }
}