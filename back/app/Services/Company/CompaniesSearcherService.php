<?php 

namespace App\Services\Company;

use App\Converter\Company\CompanyToCompanyResponseConverter;
use App\Dto\Request\Company\CompanyFilterRequest;
use App\Dto\Response\Company\CompanyResponse;
use App\Models\CompanyModel;

final class CompaniesSearcherService {

    private CompanyModel $companyModel;
    private CompanyToCompanyResponseConverter $converter;

    public function __construct() {
        $this->companyModel = new CompanyModel();
        $this->converter = new CompanyToCompanyResponseConverter();
    }

    /**
     * @return CompanyResponse[]
     */
    public function searchResponses(CompanyFilterRequest $request): array
    {
        $entities = $this->companyModel->search($request);

        $responses = [];
        foreach ($entities as $entity) {
            $responses[] = $this->converter->convert($entity);
        }

        return $responses;
    }
}