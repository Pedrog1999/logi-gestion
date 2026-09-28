<?php

namespace App\Exceptions;

use RuntimeException;
use Throwable;

abstract class AppException extends RuntimeException
{
    protected int $statusCode = 500;
    protected string $errorCode = 'internal_error';
    protected array $errors = [];

    public function __construct(string $message = '', array $errors = [], ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->errors = $errors;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}