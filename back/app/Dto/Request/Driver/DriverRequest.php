<?php 

namespace App\Dto\Request\Driver;

final readonly class DriverRequest {
    public function __construct(
        private string $name,
        private string $surname,
        private string $cuil,
        private string $phone,
        private string $email,
        private string $status
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getCuil(): string
    {
        return $this->cuil;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}