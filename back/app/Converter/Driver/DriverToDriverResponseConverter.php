<?php 

namespace App\Converter\Driver;

use App\Dto\Response\Driver\DriverResponse;
use App\Entity\Driver\Driver;

final class DriverToDriverResponseConverter {
    public function convert(Driver $driver): DriverResponse
    {
        return new DriverResponse(
            $driver->getId(),
            $driver->getName(),
            $driver->getSurname(),
            $driver->getCuil(),
            $driver->getPhone(),
            $driver->getEmail(),
            $driver->getStatus(),
            $driver->getCreatedAt()
        );
    }
}