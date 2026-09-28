<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use App\Security\CurrentUser;
use App\Security\JwtService;
use App\Security\PasswordHasher;
use App\Models\UserModel;
use App\Services\AuthService;
use App\Services\UserService;
use Config\Jwt;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 */
class Services extends BaseService
{
    public static function passwordHasher(bool $getShared = true): PasswordHasher
    {
        if ($getShared) {
            return static::getSharedInstance('passwordHasher');
        }

        return new PasswordHasher();
    }

    public static function currentUser(bool $getShared = true): CurrentUser
    {
        if ($getShared) {
            return static::getSharedInstance('currentUser');
        }

        return new CurrentUser();
    }

    public static function jwtService(bool $getShared = true): JwtService
    {
        if ($getShared) {
            return static::getSharedInstance('jwtService');
        }

        return new JwtService(config(Jwt::class));
    }

    public static function authService(bool $getShared = true): AuthService
    {
        if ($getShared) {
            return static::getSharedInstance('authService');
        }

        return new AuthService(new UserModel(), static::passwordHasher(), static::jwtService());
    }

    public static function userService(bool $getShared = true): UserService
    {
        if ($getShared) {
            return static::getSharedInstance('userService');
        }

        return new UserService(new UserModel(), static::passwordHasher());
    }
}