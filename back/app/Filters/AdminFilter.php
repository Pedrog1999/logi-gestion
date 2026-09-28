<?php

namespace App\Filters;

use App\Exceptions\ForbiddenException;
use App\Exceptions\UnauthorizedException;
use CodeIgniter\HTTP\RequestInterface;

class AdminFilter extends ApiFilter
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $user = service('currentUser')->get();

        if ($user === null) {
            return $this->fail(new UnauthorizedException());
        }

        if (! $user->isAdmin()) {
            return $this->fail(new ForbiddenException());
        }

        return null;
    }
}