<?php

namespace App\Exceptions;

class ValidationException extends AppException
{
    protected int $statusCode = 422;
    protected string $errorCode = 'validation_error';

    public function __construct(array $errors, string $message = 'Los datos enviados no son válidos')
    {
        parent::__construct($message, $errors);
    }
}