<?php

namespace App\Services;

use App\Converters\UserConverter;
use App\DTO\Request\LoginRequest;
use App\DTO\Request\RegisterRequest;
use App\DTO\Response\AuthResponse;
use App\DTO\Response\UserResponse;
use App\Exceptions\UnauthorizedException;
use App\Models\UserModel;

final class AuthService
{
    public function __construct(
        private UserService $users = new UserService(),
        private TokenService $tokens = new TokenService(),
        private UserModel $model = new UserModel(),
    ) {}

    public function register(RegisterRequest $req): AuthResponse
    {
        $user  = $this->users->create($req);
        $token = $this->tokens->issue($user, true);

        return new AuthResponse(
            UserConverter::toResponse($user),
            $token['token'],
            $token['expiresAt'],
        );
    }

    public function login(LoginRequest $req): AuthResponse
    {
        $user = $this->model->findByEmail($req->email);

        // mismo mensaje para email inexistente y password incorrecta
        if (! $user || ! $user->verifyPassword($req->password)) {
            throw new UnauthorizedException('Email o contraseña incorrectos');
        }

        $token = $this->tokens->issue($user, $req->remember);

        return new AuthResponse(
            UserConverter::toResponse($user),
            $token['token'],
            $token['expiresAt'],
        );
    }

    public function me(array $payload): UserResponse
    {
        return $this->users->getById((int)$payload['sub']);
    }

    /** Emite uno nuevo y revoca el actual */
    public function refresh(array $payload, ?string $currentToken): AuthResponse
    {
        $user  = $this->users->getEntity((int)$payload['sub']);
        $token = $this->tokens->rotate($user, $currentToken, true);

        return new AuthResponse(
            UserConverter::toResponse($user),
            $token['token'],
            $token['expiresAt'],
        );
    }

    /** Logout real: el token queda muerto en la base */
    public function logout(?string $currentToken): void
    {
        $this->tokens->revoke($currentToken);
    }

    /** Cierra todas las demás sesiones, deja viva la actual */
    public function logoutAll(array $payload): void
    {
        $this->tokens->revokeAll((int)$payload['sub'], (int)($payload['tid'] ?? 0) ?: null);
    }

    public function sessions(array $payload): array
    {
        return $this->tokens->activeSessions((int)$payload['sub']);
    }
}