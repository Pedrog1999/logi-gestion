<?php

namespace App\Exceptions;

class UserAlreadyExistsException extends AppException
{
    protected int $statusCode = 409;
    protected string $errorCode = 'user_already_exists';

    public function __construct(array $errors, string $message = 'El usuario ya existe')
    {
        parent::__construct($message, $errors);
    }
}