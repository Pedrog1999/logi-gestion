<?php

namespace App\Security;

use App\Entities\UserEntity;
use App\Exceptions\UnauthorizedException;

/** Guarda el usuario autenticado durante el request (lo setea AuthFilter). */
class CurrentUser
{
    private ?UserEntity $user = null;

    public function set(UserEntity $user): void
    {
        $this->user = $user;
    }

    public function get(): ?UserEntity
    {
        return $this->user;
    }

    public function getOrFail(): UserEntity
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        return $this->user;
    }
}