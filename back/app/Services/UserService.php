<?php

namespace App\Services;

use App\Converters\UserConverter;
use App\DTO\Request\CreateUserRequest;
use App\DTO\Request\UpdateUserRequest;
use App\Entities\UserEntity;
use App\Exceptions\SelfModificationException;
use App\Exceptions\UserAlreadyExistsException;
use App\Exceptions\UserNotFoundException;
use App\Models\UserModel;
use App\Security\PasswordHasher;
use RuntimeException;

class UserService
{
    private UserModel $userModel;
    private PasswordHasher $hasher;

    public function __construct(UserModel $userModel, PasswordHasher $hasher)
    {
        $this->userModel = $userModel;
        $this->hasher    = $hasher;
    }

    public function create(CreateUserRequest $request): UserEntity
    {
        $this->assertUnique($request->getUsername(), $request->getEmail());

        $entity = UserConverter::toEntity($request, $this->hasher->hash($request->getPassword()));
        $id     = $this->userModel->insert($entity);

        if ($id === false) {
            throw new RuntimeException('No se pudo crear el usuario.');
        }

        return $this->getById((int) $id);
    }

    /** @return UserEntity[] */
    public function list(?bool $active = null): array
    {
        return $this->userModel->findAllByActive($active);
    }

    public function getById(int $id): UserEntity
    {
        $user = $this->userModel->find($id);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function update(int $id, UpdateUserRequest $request, UserEntity $actor): UserEntity
    {
        $user = $this->getById($id);

        if ($actor->getId() === $id && $request->getRole() !== null && $request->getRole() !== $user->getRole()) {
            throw new SelfModificationException('No podés cambiar tu propio rol');
        }

        $this->assertUnique($request->getUsername(), $request->getEmail(), $id);

        $hash = $request->getPassword() !== null ? $this->hasher->hash($request->getPassword()) : null;

        UserConverter::applyUpdate($user, $request, $hash);

        if ($user->hasChanged()) {
            $this->userModel->save($user);
        }

        return $this->getById($id);
    }

    /** Borrado lógico. */
    public function deactivate(int $id, UserEntity $actor): UserEntity
    {
        if ($actor->getId() === $id) {
            throw new SelfModificationException('No podés desactivar tu propia cuenta');
        }

        return $this->changeActive($id, false);
    }

    public function activate(int $id): UserEntity
    {
        return $this->changeActive($id, true);
    }

    private function changeActive(int $id, bool $active): UserEntity
    {
        $user = $this->getById($id);

        if ($user->isActive() !== $active) {
            $user->setActive($active);
            $this->userModel->save($user);
        }

        return $this->getById($id);
    }

    private function assertUnique(?string $username, ?string $email, ?int $exceptId = null): void
    {
        $errors = [];

        if ($username !== null && $this->userModel->usernameExists($username, $exceptId)) {
            $errors['username'] = 'El nombre de usuario ya está en uso';
        }
        if ($email !== null && $this->userModel->emailExists($email, $exceptId)) {
            $errors['email'] = 'El email ya está en uso';
        }

        if ($errors !== []) {
            throw new UserAlreadyExistsException($errors);
        }
    }
}