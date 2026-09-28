<?php 

namespace App\Dto\Response\Company;

use DateTime;

final readonly class CompanyResponse {
    public function __construct(
        public int $id,
        public string $businessName,
        public string $cuit,
        public string $phone,
        public string $email,
        public string $address,
        public DateTime $createdAt
    ) {}
}