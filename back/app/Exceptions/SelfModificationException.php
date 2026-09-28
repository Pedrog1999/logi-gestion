<?php

namespace App\Exceptions;

class SelfModificationException extends AppException
{
    protected int $statusCode = 409;
    protected string $errorCode = 'self_modification_not_allowed';

    public function __construct(string $message = 'No podés realizar esta acción sobre tu propia cuenta')
    {
        parent::__construct($message);
    }
}