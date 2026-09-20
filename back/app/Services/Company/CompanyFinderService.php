<?php 

namespace App\Services\Company;

use App\Converter\Company\CompanyToCompanyResponseConverter;
use App\Dto\Response\Company\CompanyResponse;
use App\Entity\Company\Company;
use App\Exception\Company\CompanyNotFoundException;
use App\Models\CompanyModel;

final class CompanyFinderService {

    private CompanyModel $companyModel;
    private CompanyToCompanyResponseConverter $converter;

    public function __construct() {
        $this->companyModel = new CompanyModel();
        $this->converter = new CompanyToCompanyResponseConverter();
    }

    public function find(int $id): Company
    {
        $company = $this->companyModel->find($id);

        if (empty($company)) {
            throw new CompanyNotFoundException($id);
        }

        return $company;
    }

    public function findResponse(int $id): CompanyResponse
    {
        $company = $this->find($id);

        $response = $this->converter->convert($company);

        return $response;
    }
}