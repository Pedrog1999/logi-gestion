<?php

namespace App\Entity;

use DateTime;

final class Loads
{
    public function __construct(
        private ?int $id = null,
        private string $type = '',
        private string $name = '',
        private float $commission = 0.0,
        private ?DateTime $createdAt = null,
        private ?DateTime $updatedAt = null
    ) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCommission(): float
    {
        return $this->commission;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }
}

