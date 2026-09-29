<?php 

namespace App\Converter\Company;

use App\Dto\Response\Company\CompanyResponse;
use App\Entity\Company\Company;

final class CompanyToCompanyResponseConverter {
    public function convert(Company $company): CompanyResponse
    {
        return new CompanyResponse(
            $company->getId(),
            $company->getBusinessName(),
            $company->getCuit(),
            $company->getPhone(),
            $company->getEmail(),
            $company->getAddress(),
            $company->getCreatedAt()
        );
    }
}