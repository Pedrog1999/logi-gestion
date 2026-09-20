<?php 

namespace App\Dto\Request\Company;

use App\Dto\Request\PaginationRequest;

final readonly class CompanyFilterRequest {
    public function __construct(
        private PaginationRequest $pagination,
        private ?string $businessName,
        private ?string $cuit,
        private ?string $email,
        private ?string $address
    ) {}

    public function getPagination(): PaginationRequest
    {
        return $this->pagination;
    }

    public function getBusinessName(): ?string
    {
        return $this->businessName;
    }

    public function getCuit(): ?string
    {
        return $this->cuit;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function hasBusinessName(): bool
    {
        return !empty($this->businessName);
    }

    public function hasCuit(): bool
    {
        return !empty($this->cuit);
    }

    public function hasEmail(): bool
    {
        return !empty($this->email);
    }

    public function hasAddress(): bool
    {
        return !empty($this->address);
    }
}