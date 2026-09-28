<?php

namespace App\Exceptions;

class UnauthorizedException extends AppException
{
    protected int $statusCode = 401;
    protected string $errorCode = 'unauthorized';

    public function __construct(string $message = 'No autenticado', string $errorCode = 'unauthorized')
    {
        parent::__construct($message);
        $this->errorCode = $errorCode;
    }
}