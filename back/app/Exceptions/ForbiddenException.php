<?php

namespace App\Exceptions;

class ForbiddenException extends AppException
{
    protected int $statusCode = 403;
    protected string $errorCode = 'forbidden';

    public function __construct(string $message = 'No tenés permisos para realizar esta acción')
    {
        parent::__construct($message);
    }
}