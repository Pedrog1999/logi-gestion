<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;

class User extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [
        'id' => 'integer',
    ];

    // ---------- id ----------

    public function getId(): ?int
    {
        return $this->attributes['id'] !== null
            ? (int)$this->attributes['id']
            : null;
    }

    // sin setId(): el id lo pone la base, no se setea a mano

    // ---------- username ----------

    public function getUsername(): ?string
    {
        return $this->attributes['username'] ?? null;
    }

    public function setUsername(string $username): self
    {
        $this->attributes['username'] = trim($username);
        return $this;
    }

    // ---------- email ----------

    public function getEmail(): ?string
    {
        return $this->attributes['email'] ?? null;
    }

    public function setEmail(string $email): self
    {
        $this->attributes['email'] = strtolower(trim($email));
        return $this;
    }

    // ---------- password ----------

    /** Devuelve el HASH, nunca la password en texto plano */
    public function getPassword(): ?string
    {
        return $this->attributes['password'] ?? null;
    }

    /** Recibe texto plano, guarda el hash */
    public function setPassword(string $plain): self
    {
        $this->attributes['password'] = password_hash($plain, PASSWORD_BCRYPT);
        return $this;
    }

    public function verifyPassword(string $plain): bool
    {
        return password_verify($plain, $this->attributes['password'] ?? '');
    }

    // ---------- role ----------

    public function getRole(): string
    {
        return strtoupper($this->attributes['role'] ?? 'USER');
    }

    public function setRole(string $role): self
    {
        $this->attributes['role'] = strtoupper(trim($role));
        return $this;
    }

    public function isAdmin(): bool
    {
        return $this->getRole() === 'ADMIN';
    }

    // ---------- created_at / updated_at ----------

    public function getCreatedAt(): ?Time
    {
        return $this->mutateDate($this->attributes['created_at'] ?? null);
    }

    public function getUpdatedAt(): ?Time
    {
        return $this->mutateDate($this->attributes['updated_at'] ?? null);
    }

    // no hay setCreatedAt/setUpdatedAt: los maneja $useTimestamps en el Model
}