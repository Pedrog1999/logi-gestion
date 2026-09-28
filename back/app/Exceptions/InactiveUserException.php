<?php

namespace App\Exceptions;

class InactiveUserException extends AppException
{
    protected int $statusCode = 403;
    protected string $errorCode = 'user_inactive';

    public function __construct(string $message = 'El usuario está inactivo')
    {
        parent::__construct($message);
    }
}