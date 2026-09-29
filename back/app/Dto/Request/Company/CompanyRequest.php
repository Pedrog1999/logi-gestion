<?php 

namespace App\Dto\Request\Company;

final readonly class CompanyRequest {
    public function __construct(
        private string $businessName,
        private string $cuit,
        private string $phone,
        private string $email,
        private string $address
    ) {}

    public function getBusinessName(): string
    {
        return $this->businessName;
    }

    public function getCuit(): string
    {
        return $this->cuit;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddress(): string
    {
        return $this->address;
    }
}