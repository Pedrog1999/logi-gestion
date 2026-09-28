<?php

namespace App\Exceptions;

class InvalidCredentialsException extends AppException
{
    protected int $statusCode = 401;
    protected string $errorCode = 'invalid_credentials';

    public function __construct(string $message = 'Credenciales inválidas')
    {
        parent::__construct($message);
    }
}