<?php

namespace App\Controllers\Api;

use App\DTO\Request\LoginRequest;
use App\DTO\Request\RegisterRequest;
use App\Services\AuthService;
use App\Services\TokenService;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseApiController
{
    private AuthService $auth;

    public function __construct()
    {
        $this->auth = new AuthService();
    }

    /** POST /api/auth/register */
    public function register(): ResponseInterface
    {
        return $this->handle(function () {
            $dto = RegisterRequest::fromArray($this->body());
            return $this->ok($this->auth->register($dto), 'Cuenta creada', 201);
        });
    }

    /** POST /api/auth/login */
    public function login(): ResponseInterface
    {
        return $this->handle(function () {
            $dto = LoginRequest::fromArray($this->body());
            return $this->ok($this->auth->login($dto), 'Sesión iniciada');
        });
    }

    /** GET /api/auth/me  [auth] */
    public function me(): ResponseInterface
    {
        return $this->handle(fn () => $this->ok($this->auth->me($this->auth())));
    }

    /** POST /api/auth/refresh  [auth] */
    public function refresh(): ResponseInterface
    {
        return $this->handle(fn () => $this->ok(
            $this->auth->refresh($this->auth(), $this->rawToken()),
            'Token renovado'
        ));
    }

    /** POST /api/auth/logout  [auth] */
    public function logout(): ResponseInterface
    {
        return $this->handle(function () {
            $this->auth->logout($this->rawToken());
            return $this->ok(null, 'Sesión cerrada');
        });
    }

    /** POST /api/auth/logout-all  [auth] */
    public function logoutAll(): ResponseInterface
    {
        return $this->handle(function () {
            $this->auth->logoutAll($this->auth());
            return $this->ok(null, 'Se cerraron las demás sesiones');
        });
    }

    /** GET /api/auth/sessions  [auth] */
    public function sessions(): ResponseInterface
    {
        return $this->handle(fn () => $this->ok($this->auth->sessions($this->auth())));
    }

    private function rawToken(): ?string
    {
        return $this->request->getHeaderLine(TokenService::HEADER) ?: null;
    }
}