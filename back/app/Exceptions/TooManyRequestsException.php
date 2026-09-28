<?php

namespace App\Exceptions;

class TooManyRequestsException extends AppException
{
    protected int $statusCode = 429;
    protected string $errorCode = 'too_many_requests';

    public function __construct(string $message = 'Demasiados intentos, probá de nuevo en un minuto')
    {
        parent::__construct($message);
    }
}