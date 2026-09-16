<?php 

namespace App\Services\Driver;

use App\Converter\Driver\DriverToDriverResponseConverter;
use App\Dto\Request\Driver\DriverFilterRequest;
use App\Dto\Response\Driver\DriverResponse;
use App\Models\DriverModel;

final class DriversSearcherService {

    private DriverModel $driverModel;
    private DriverToDriverResponseConverter $converter;

    public function __construct() {
        $this->driverModel = new DriverModel();
        $this->converter = new DriverToDriverResponseConverter();
    }

    /**
     * @return DriverResponse[]
     */
    public function searchResponses(DriverFilterRequest $request): array
    {
        $entities = $this->driverModel->search($request);

        $responses = [];
        foreach ($entities as $entity) {
            $responses[] = $this->converter->convert($entity);
        }

        return $responses;
    }
}