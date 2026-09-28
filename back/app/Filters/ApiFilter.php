<?php

namespace App\Filters;

use App\DTO\Response\ErrorResponse;
use App\Exceptions\AppException;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

abstract class ApiFilter implements FilterInterface
{
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }

    protected function fail(AppException $e): ResponseInterface
    {
        return service('response')
            ->setStatusCode($e->getStatusCode())
            ->setJSON(ErrorResponse::fromException($e)->toArray());
    }
}