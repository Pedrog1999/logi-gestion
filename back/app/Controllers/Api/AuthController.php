<?php

namespace App\Controllers\Api;

use App\Converters\UserConverter;
use App\DTO\Request\LoginRequest;
use App\DTO\Response\LoginResponse;
use App\Services\AuthService;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends ApiController
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = service('authService');
    }

    public function login(): ResponseInterface
    {
        return $this->handle(function () {
            $payload = $this->getPayload();
            $this->validatePayload($payload, LoginRequest::rules());

            $user = $this->authService->login(LoginRequest::fromArray($payload));

            $response = new LoginResponse(
                $this->authService->generateToken($user),
                'Bearer',
                $this->authService->getTokenTtl(),
                UserConverter::toResponse($user)
            );

            return $this->success($response->toArray());
        });
    }

    public function me(): ResponseInterface
    {
        return $this->handle(function () {
            $user = service('currentUser')->getOrFail();

            return $this->success(UserConverter::toResponse($user)->toArray());
        });
    }
}