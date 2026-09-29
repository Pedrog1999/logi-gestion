<?php

namespace App\Dto\Request\Load;

final readonly class LoadRequest
{
    public function __construct(
        private string $type,
        private string $name,
        private float $commission
    ) {}

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
}
