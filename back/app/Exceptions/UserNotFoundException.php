<?php

namespace App\Exceptions;

class UserNotFoundException extends AppException
{
    protected int $statusCode = 404;
    protected string $errorCode = 'user_not_found';

    public function __construct(string $message = 'Usuario no encontrado')
    {
        parent::__construct($message);
    }
}