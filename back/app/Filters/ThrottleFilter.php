<?php

namespace App\Filters;

use App\Exceptions\TooManyRequestsException;
use CodeIgniter\HTTP\RequestInterface;

class ThrottleFilter extends ApiFilter
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $key = 'login_' . md5($request->getIPAddress());

        if (! service('throttler')->check($key, 10, MINUTE)) {
            return $this->fail(new TooManyRequestsException());
        }

        return null;
    }
}