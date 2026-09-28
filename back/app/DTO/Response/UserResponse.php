<?php

namespace App\DTO\Response;

class UserResponse
{
    private int $id;
    private string $username;
    private string $email;
    private string $role;
    private bool $active;
    private ?string $createdAt;
    private ?string $updatedAt;

    public function __construct(
        int $id,
        string $username,
        string $email,
        string $role,
        bool $active,
        ?string $createdAt,
        ?string $updatedAt
    ) {
        $this->id        = $id;
        $this->username  = $username;
        $this->email     = $email;
        $this->role      = $role;
        $this->active    = $active;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id'        => $this->id,
            'username'  => $this->username,
            'email'     => $this->email,
            'role'      => $this->role,
            'active'    => $this->active,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}