<?php

namespace App\DTO\Response;

use App\Exceptions\AppException;

class ErrorResponse
{
    private string $code;
    private string $message;
    private array $errors;

    public function __construct(string $code, string $message, array $errors = [])
    {
        $this->code    = $code;
        $this->message = $message;
        $this->errors  = $errors;
    }

    public static function fromException(AppException $e): self
    {
        return new self($e->getErrorCode(), $e->getMessage(), $e->getErrors());
    }

    public static function internal(): self
    {
        return new self('internal_error', 'Ocurrió un error inesperado');
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function toArray(): array
    {
        $error = ['code' => $this->code, 'message' => $this->message];

        if ($this->errors !== []) {
            $error['errors'] = $this->errors;
        }

        return ['error' => $error];
    }
}