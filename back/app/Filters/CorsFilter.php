<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;

class CorsFilter extends ApiFilter
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $response = service('response');
        $origin   = $request->getHeaderLine('Origin');
        $allowed  = array_map('trim', explode(',', (string) env('CORS_ALLOWED_ORIGINS', 'http://localhost:5173')));

        if ($origin !== '' && in_array($origin, $allowed, true)) {
            $response->setHeader('Access-Control-Allow-Origin', $origin)
                ->setHeader('Vary', 'Origin')
                ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PATCH, DELETE, OPTIONS')
                ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, Accept')
                ->setHeader('Access-Control-Max-Age', '86400');
        }

        if (strtoupper($request->getMethod()) === 'OPTIONS') {
            return $response->setStatusCode(204);
        }

        return null;
    }
}