<?php 

namespace App\Entity\Driver;

use App\Dto\Request\Driver\DriverRequest;
use DateTime;

final class Driver {
    public function __construct(
        private ?int $id,
        private string $name,
        private string $surname,
        private string $cuil,
        private string $phone,
        private string $email,
        private string $status,
        private DateTime $createdAt
    ) {}

    public function update(DriverRequest $request): void
    {
        $this->name = $request->getName();
        $this->surname = $request->getSurname();
        $this->cuil = $request->getCuil();
        $this->phone = $request->getPhone();
        $this->email = $request->getEmail();
        $this->status = $request->getStatus();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public static function convertFromRequest(DriverRequest $request): Driver
    {
        return new Driver(
            null,
            $request->getName(),
            $request->getSurname(),
            $request->getCuil(),
            $request->getPhone(),
            $request->getEmail(),
            $request->getStatus(),
            new DateTime()
        );
    }
}