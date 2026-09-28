<?php

namespace App\DTO\Request;

use App\Entities\UserEntity;

class CreateUserRequest
{
    private string $username;
    private string $email;
    private string $password;
    private string $role;

    private function __construct(string $username, string $email, string $password, string $role)
    {
        $this->username = $username;
        $this->email    = $email;
        $this->password = $password;
        $this->role     = $role;
    }

    public static function rules(): array
    {
        return [
            'username' => 'required|string|min_length[3]|max_length[100]|regex_match[/^[A-Za-z0-9_.-]+$/]',
            'email'    => 'required|string|valid_email|max_length[150]',
            'password' => 'required|string|min_length[8]|max_length[128]',
            'role'     => 'if_exist|in_list[' . implode(',', UserEntity::ROLES) . ']',
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            trim((string) ($data['username'] ?? '')),
            strtolower(trim((string) ($data['email'] ?? ''))),
            (string) ($data['password'] ?? ''),
            (string) ($data['role'] ?? UserEntity::ROLE_USER)
        );
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}