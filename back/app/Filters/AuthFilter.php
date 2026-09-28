<?php

namespace App\Filters;

use App\Exceptions\AppException;
use App\Exceptions\UnauthorizedException;
use CodeIgniter\HTTP\RequestInterface;

class AuthFilter extends ApiFilter
{
    public function before(RequestInterface $request, $arguments = null)
    {
        try {
            $header = $request->getHeaderLine('Authorization');

            if (! preg_match('/^Bearer\s+(\S+)$/i', $header, $matches)) {
                throw new UnauthorizedException('Token no informado', 'token_missing');
            }

            $user = service('authService')->authenticateToken($matches[1]);
            service('currentUser')->set($user);
        } catch (AppException $e) {
            return $this->fail($e);
        }

        return null;
    }
}