<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class UserEntity extends Entity
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER  = 'user';
    public const ROLES      = [self::ROLE_ADMIN, self::ROLE_USER];

    // ---------- Getters ----------
    public function getId(): ?int
    {
        return isset($this->attributes['id']) ? (int) $this->attributes['id'] : null;
    }

    public function getUsername(): string
    {
        return (string) ($this->attributes['username'] ?? '');
    }

    public function getEmail(): string
    {
        return (string) ($this->attributes['email'] ?? '');
    }

    public function getPassword(): string
    {
        return (string) ($this->attributes['password'] ?? '');
    }

    public function getRole(): string
    {
        return (string) ($this->attributes['role'] ?? self::ROLE_USER);
    }

    public function isActive(): bool
    {
        return (bool) ($this->attributes['active'] ?? false);
    }

    public function isAdmin(): bool
    {
        return $this->getRole() === self::ROLE_ADMIN;
    }

    public function getCreatedAt(): ?string
    {
        return $this->attributes['created_at'] ?? null;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->attributes['updated_at'] ?? null;
    }

    // ---------- Setters ----------
    public function setUsername(string $username): self
    {
        $this->attributes['username'] = trim($username);

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->attributes['email'] = strtolower(trim($email));

        return $this;
    }

    /** Recibe el HASH, nunca la clave en texto plano. */
    public function setPassword(string $passwordHash): self
    {
        $this->attributes['password'] = $passwordHash;

        return $this;
    }

    public function setRole(string $role): self
    {
        $this->attributes['role'] = $role;

        return $this;
    }

    public function setActive(bool $active): self
    {
        $this->attributes['active'] = $active ? 1 : 0;

        return $this;
    }
}