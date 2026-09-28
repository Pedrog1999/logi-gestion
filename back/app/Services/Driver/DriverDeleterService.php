<?php 

namespace App\Services\Driver;

use App\Models\DriverModel;

final class DriverDeleterService {

    private DriverModel $driverModel;
    private DriverFinderService $driverFinderService;

    public function __construct() {
        $this->driverModel = new DriverModel();
        $this->driverFinderService = new DriverFinderService();
    }

    public function delete(int $id): void
    {
        $driver = $this->driverFinderService->find($id);

        $this->driverModel->delete($driver->getId());
    }
}