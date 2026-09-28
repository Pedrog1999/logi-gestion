<?php

namespace App\DTO\Response;

class LoginResponse
{
    private string $token;
    private string $tokenType;
    private int $expiresIn;
    private UserResponse $user;

    public function __construct(string $token, string $tokenType, int $expiresIn, UserResponse $user)
    {
        $this->token     = $token;
        $this->tokenType = $tokenType;
        $this->expiresIn = $expiresIn;
        $this->user      = $user;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    public function getUser(): UserResponse
    {
        return $this->user;
    }

    public function toArray(): array
    {
        return [
            'token'     => $this->token,
            'tokenType' => $this->tokenType,
            'expiresIn' => $this->expiresIn,
            'user'      => $this->user->toArray(),
        ];
    }
}