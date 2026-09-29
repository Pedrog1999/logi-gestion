<?php 

namespace App\Services\Driver;

use App\Converter\Driver\DriverToDriverResponseConverter;
use App\Dto\Request\Driver\DriverRequest;
use App\Dto\Response\Driver\DriverResponse;
use App\Models\DriverModel;

final class DriverUpdaterService {

    private DriverModel $driverModel;
    private DriverFinderService $driverFinderService;
    private DriverToDriverResponseConverter $converter;

    public function __construct() {
        $this->driverModel = new DriverModel();
        $this->driverFinderService = new DriverFinderService();
        $this->converter = new DriverToDriverResponseConverter();
    }

    public function update(DriverRequest $request, int $id): DriverResponse
    {
        $driver = $this->driverFinderService->find($id);

        $driver->update($request);

        $driver = $this->driverModel->update($driver);

        $response = $this->converter->convert($driver);

        return $response;
    }
}