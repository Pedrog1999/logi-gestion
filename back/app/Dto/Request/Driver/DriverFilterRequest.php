<?php 

namespace App\Dto\Request\Driver;

use App\Dto\Request\PaginationRequest;

final readonly class DriverFilterRequest {
    public function __construct(
        private PaginationRequest $pagination,
        private ?string $name,
        private ?string $surname,
        private ?string $cuil,
        private ?string $email,
        private ?string $status
    ) {}

    public function getPagination(): PaginationRequest
    {
        return $this->pagination;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function getCuil(): ?string
    {
        return $this->cuil;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function hasName(): bool
    {
        return !empty($this->name);
    }

    public function hasSurname(): bool
    {
        return !empty($this->surname);
    }

    public function hasCuil(): bool
    {
        return !empty($this->cuil);
    }

    public function hasEmail(): bool
    {
        return !empty($this->email);
    }

    public function hasStatus(): bool
    {
        return !empty($this->status);
    }
}