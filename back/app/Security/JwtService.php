<?php

namespace App\Security;

use App\Entities\UserEntity;
use App\Exceptions\UnauthorizedException;
use Config\Jwt as JwtConfig;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use RuntimeException;
use Throwable;

class JwtService
{
    private const ALGORITHM = 'HS256';

    private JwtConfig $config;

    public function __construct(JwtConfig $config)
    {
        if (strlen($config->secret) < 32) {
            throw new RuntimeException('jwt.secret debe tener al menos 32 caracteres (revisá el .env).');
        }

        $this->config = $config;
    }

    public function generate(UserEntity $user): string
    {
        $now = time();

        return JWT::encode([
            'iss' => $this->config->issuer,
            'iat' => $now,
            'nbf' => $now,
            'exp' => $now + $this->config->ttl,
            'sub' => (string) $user->getId(),
        ], $this->config->secret, self::ALGORITHM);
    }

    public function decode(string $token): array
    {
        try {
            $payload = (array) JWT::decode($token, new Key($this->config->secret, self::ALGORITHM));
        } catch (ExpiredException $e) {
            throw new UnauthorizedException('El token expiró', 'token_expired');
        } catch (Throwable $e) {
            throw new UnauthorizedException('Token inválido', 'token_invalid');
        }

        if (($payload['iss'] ?? null) !== $this->config->issuer) {
            throw new UnauthorizedException('Token inválido', 'token_invalid');
        }

        return $payload;
    }

    public function getTtl(): int
    {
        return $this->config->ttl;
    }
}