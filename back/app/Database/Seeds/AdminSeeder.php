<?php

namespace App\Database\Seeds;

use App\DTO\Request\CreateUserRequest;
use App\Entities\UserEntity;
use App\Exceptions\UserAlreadyExistsException;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $username = (string) env('ADMIN_USERNAME', 'admin');
        $email    = (string) env('ADMIN_EMAIL', 'admin@example.com');
        $password = (string) env('ADMIN_PASSWORD', '');

        if (strlen($password) < 8) {
            CLI::error('Definí ADMIN_PASSWORD (mínimo 8 caracteres) en el .env');

            return;
        }

        try {
            service('userService')->create(CreateUserRequest::fromArray([
                'username' => $username,
                'email'    => $email,
                'password' => $password,
                'role'     => UserEntity::ROLE_ADMIN,
            ]));

            CLI::write("Admin '{$username}' creado.", 'green');
        } catch (UserAlreadyExistsException $e) {
            CLI::write('El admin ya existe, no se hizo nada.', 'yellow');
        }
    }
}