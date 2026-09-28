<?php

namespace App\Controllers\Api;

use App\Converters\UserConverter;
use App\DTO\Request\CreateUserRequest;
use App\DTO\Request\UpdateUserRequest;
use App\Exceptions\ValidationException;
use App\Security\CurrentUser;
use App\Services\UserService;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends ApiController
{
    private UserService $userService;
    private CurrentUser $currentUser;

    public function __construct()
    {
        $this->userService = service('userService');
        $this->currentUser = service('currentUser');
    }

    /** GET /api/users?active=1|0 */
    public function index(): ResponseInterface
    {
        return $this->handle(function () {
            $raw    = $this->request->getGet('active');
            $active = $raw === null ? null : filter_var($raw, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

            return $this->success(UserConverter::toResponseList($this->userService->list($active)));
        });
    }

    /** GET /api/users/{id} */
    public function show(int $id): ResponseInterface
    {
        return $this->handle(function () use ($id) {
            $user = $this->userService->getById($id);

            return $this->success(UserConverter::toResponse($user)->toArray());
        });
    }

    /** POST /api/users */
    public function create(): ResponseInterface
    {
        return $this->handle(function () {
            $payload = $this->getPayload();
            $this->validatePayload($payload, CreateUserRequest::rules());

            $user = $this->userService->create(CreateUserRequest::fromArray($payload));

            return $this->success(UserConverter::toResponse($user)->toArray(), 201);
        });
    }

    /** PATCH /api/users/{id} */
    public function update(int $id): ResponseInterface
    {
        return $this->handle(function () use ($id) {
            $payload = $this->getPayload();
            $this->validatePayload($payload, UpdateUserRequest::rules());

            $request = UpdateUserRequest::fromArray($payload);

            if ($request->isEmpty()) {
                throw new ValidationException(['body' => 'Enviá al menos un campo para modificar']);
            }

            $user = $this->userService->update($id, $request, $this->currentUser->getOrFail());

            return $this->success(UserConverter::toResponse($user)->toArray());
        });
    }

    /** DELETE /api/users/{id} -> borrado lógico */
    public function deactivate(int $id): ResponseInterface
    {
        return $this->handle(function () use ($id) {
            $user = $this->userService->deactivate($id, $this->currentUser->getOrFail());

            return $this->success(UserConverter::toResponse($user)->toArray());
        });
    }

    /** PATCH /api/users/{id}/activate */
    public function activate(int $id): ResponseInterface
    {
        return $this->handle(function () use ($id) {
            $user = $this->userService->activate($id);

            return $this->success(UserConverter::toResponse($user)->toArray());
        });
    }
}