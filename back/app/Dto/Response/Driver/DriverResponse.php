<?php 

namespace App\Dto\Response\Driver;

use DateTime;

final readonly class DriverResponse {
    public function __construct(
        public int $id,
        public string $name,
        public string $surname,
        public string $cuil,
        public string $phone,
        public string $email,
        public string $status,
        public DateTime $createdAt
    ) {}
}