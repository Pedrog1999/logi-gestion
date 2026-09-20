<?php 

namespace App\Entity\Company;

use App\Dto\Request\Company\CompanyRequest;
use DateTime;

final class Company {
    public function __construct(
        private ?int $id,
        private string $businessName,
        private string $cuit,
        private string $phone,
        private string $email,
        private string $address,
        private DateTime $createdAt
    ) {}

    public function update(CompanyRequest $request): void
    {
        $this->businessName = $request->getBusinessName();
        $this->cuit = $request->getCuit();
        $this->phone = $request->getPhone();
        $this->email = $request->getEmail();
        $this->address = $request->getAddress();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public static function convertFromRequest(CompanyRequest $request): Company
    {
        return new Company(
            null,
            $request->getBusinessName(),
            $request->getCuit(),
            $request->getPhone(),
            $request->getEmail(),
            $request->getAddress(),
            new DateTime()
        );
    }
}