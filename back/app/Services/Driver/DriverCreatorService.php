<?php 

namespace App\Services\Driver;

use App\Converter\Driver\DriverToDriverResponseConverter;
use App\Dto\Request\Driver\DriverRequest;
use App\Dto\Response\Driver\DriverResponse;
use App\Entity\Driver\Driver;
use App\Models\DriverModel;

final class DriverCreatorService {

    private DriverModel $driverModel;
    private DriverToDriverResponseConverter $converter;

    public function __construct() {
        $this->driverModel = new DriverModel();
        $this->converter = new DriverToDriverResponseConverter();
    }

    public function create(DriverRequest $request): DriverResponse
    {
        $driver = Driver::convertFromRequest($request);

        $newDriver = $this->driverModel->insert($driver);

        $driverResponse = $this->converter->convert($newDriver);

        return $driverResponse;
    }
}