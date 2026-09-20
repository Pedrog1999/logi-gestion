<?php 

namespace App\Converter\Company;

use App\Entity\Company\Company;
use DateTime;

final class PrimitiveToCompanyConverter {
    public function convert(object $primitive): Company
    {
        return new Company(
            $primitive->id,
            $primitive->business_name,
            $primitive->cuit,
            $primitive->phone,
            $primitive->email,
            $primitive->address,
            new DateTime($primitive->created_at)
        );
    }
}