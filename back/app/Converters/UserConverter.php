<?php

namespace App\Converters;

use App\DTO\Request\CreateUserRequest;
use App\DTO\Request\UpdateUserRequest;
use App\DTO\Response\UserResponse;
use App\Entities\UserEntity;
use DateTimeImmutable;

class UserConverter
{
    /** CreateUserRequest -> UserEntity (recibe el hash ya generado). */
    public static function toEntity(CreateUserRequest $request, string $passwordHash): UserEntity
    {
        return (new UserEntity())
            ->setUsername($request->getUsername())
            ->setEmail($request->getEmail())
            ->setPassword($passwordHash)
            ->setRole($request->getRole())
            ->setActive(true);
    }

    /** Aplica sobre la entity solo los campos que vinieron en el request. */
    public static function applyUpdate(UserEntity $entity, UpdateUserRequest $request, ?string $passwordHash): UserEntity
    {
        if ($request->getUsername() !== null) {
            $entity->setUsername($request->getUsername());
        }
        if ($request->getEmail() !== null) {
            $entity->setEmail($request->getEmail());
        }
        if ($request->getRole() !== null) {
            $entity->setRole($request->getRole());
        }
        if ($passwordHash !== null) {
            $entity->setPassword($passwordHash);
        }

        return $entity;
    }

    /** UserEntity -> UserResponse (nunca expone el password). */
    public static function toResponse(UserEntity $user): UserResponse
    {
        return new UserResponse(
            (int) $user->getId(),
            $user->getUsername(),
            $user->getEmail(),
            $user->getRole(),
            $user->isActive(),
            self::formatDate($user->getCreatedAt()),
            self::formatDate($user->getUpdatedAt())
        );
    }

    /** @param UserEntity[] $users @return array[] */
    public static function toResponseList(array $users): array
    {
        return array_map(static fn (UserEntity $u) => self::toResponse($u)->toArray(), $users);
    }

    private static function formatDate(?string $value): ?string
    {
        return $value === null ? null : (new DateTimeImmutable($value))->format(DATE_ATOM);
    }
}