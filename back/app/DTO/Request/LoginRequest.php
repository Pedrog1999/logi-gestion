<?php

namespace App\DTO\Request;

class LoginRequest
{
    private string $username;
    private string $password;

    private function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public static function rules(): array
    {
        return [
            'username' => 'required|string|max_length[100]',
            'password' => 'required|string|max_length[255]',
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            trim((string) ($data['username'] ?? '')),
            (string) ($data['password'] ?? '')
        );
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}