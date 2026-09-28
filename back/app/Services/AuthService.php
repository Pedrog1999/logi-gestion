<?php

namespace App\Services;

use App\DTO\Request\LoginRequest;
use App\Entities\UserEntity;
use App\Exceptions\InactiveUserException;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\UnauthorizedException;
use App\Models\UserModel;
use App\Security\JwtService;
use App\Security\PasswordHasher;

class AuthService
{
    private UserModel $userModel;
    private PasswordHasher $hasher;
    private JwtService $jwt;

    public function __construct(UserModel $userModel, PasswordHasher $hasher, JwtService $jwt)
    {
        $this->userModel = $userModel;
        $this->hasher    = $hasher;
        $this->jwt       = $jwt;
    }

    /** Valida usuario + clave y que la cuenta esté activa. */
    public function login(LoginRequest $request): UserEntity
    {
        $user = $this->userModel->findByUsername($request->getUsername());

        // Mismo error si no existe o si la clave no coincide
        if ($user === null || ! $this->hasher->verify($request->getPassword(), $user->getPassword())) {
            throw new InvalidCredentialsException();
        }

        if (! $user->isActive()) {
            throw new InactiveUserException();
        }

        return $user;
    }

    public function generateToken(UserEntity $user): string
    {
        return $this->jwt->generate($user);
    }

    public function getTokenTtl(): int
    {
        return $this->jwt->getTtl();
    }

    /** Valida el token y verifica en BD que el usuario siga existiendo y activo. */
    public function authenticateToken(string $token): UserEntity
    {
        $payload = $this->jwt->decode($token);
        $userId  = isset($payload['sub']) ? (int) $payload['sub'] : 0;
        $user    = $userId > 0 ? $this->userModel->find($userId) : null;

        if ($user === null || ! $user->isActive()) {
            throw new UnauthorizedException('Sesión inválida', 'session_invalid');
        }

        return $user;
    }
}