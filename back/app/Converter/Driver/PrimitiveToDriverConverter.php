<?php 

namespace App\Converter\Driver;

use App\Entity\Driver\Driver;
use DateTime;

final class PrimitiveToDriverConverter {
    public function convert(object $primitive): Driver
    {
        return new Driver(
            $primitive->id,
            $primitive->name,
            $primitive->surname,
            $primitive->cuil,
            $primitive->phone,
            $primitive->email,
            $primitive->status,
            new DateTime($primitive->created_at)
        );
    }
}