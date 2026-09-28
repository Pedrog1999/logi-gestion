<?php

namespace App\Exceptions;

class BadRequestException extends AppException
{
    protected int $statusCode = 400;
    protected string $errorCode = 'bad_request';

    public function __construct(string $message = 'Solicitud inválida')
    {
        parent::__construct($message);
    }
}