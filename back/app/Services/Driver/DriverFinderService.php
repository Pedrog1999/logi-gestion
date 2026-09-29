<?php 

namespace App\Services\Driver;

use App\Converter\Driver\DriverToDriverResponseConverter;
use App\Dto\Response\Driver\DriverResponse;
use App\Entity\Driver\Driver;
use App\Exception\Driver\DriverNotFoundException;
use App\Models\DriverModel;

final class DriverFinderService {

    private DriverModel $driverModel;
    private DriverToDriverResponseConverter $converter;

    public function __construct() {
        $this->driverModel = new DriverModel();
        $this->converter = new DriverToDriverResponseConverter();
    }

    public function find(int $id): Driver
    {
        $driver = $this->driverModel->find($id);

        if (empty($driver)) {
            throw new DriverNotFoundException($id);
        }

        return $driver;
    }

    public function findResponse(int $id): DriverResponse
    {
        $driver = $this->find($id);

        $response = $this->converter->convert($driver);

        return $response;
    }
}