<?php 

namespace App\Services\Company;

use App\Models\CompanyModel;

final class CompanyDeleterService {

    private CompanyModel $companyModel;
    private CompanyFinderService $companyFinderService;

    public function __construct() {
        $this->companyModel = new CompanyModel();
        $this->companyFinderService = new CompanyFinderService();
    }

    public function delete(int $id): void
    {
        $company = $this->companyFinderService->find($id);

        $this->companyModel->delete($company->getId());
    }
}