<?php

namespace App\Services;

use App\Entities\User;
use App\Exceptions\UnauthorizedException;
use App\Models\UserTokenModel;

final class TokenService
{
    /** Nombre del header donde viaja el token (NO es Bearer) */
    public const HEADER = 'X-Auth-Token';

    /** Vida del token: 7 días */
    private const TTL = 604800;

    /** TTL corto cuando NO tildan "Recordarme": 2 horas */
    private const TTL_SHORT = 7200;

    /** Máximo de sesiones simultáneas por usuario (0 = sin límite) */
    private const MAX_SESSIONS = 5;

    private UserTokenModel $tokens;

    public function __construct(?UserTokenModel $tokens = null)
    {
        $this->tokens = $tokens ?? new UserTokenModel();
    }

    public function ttl(bool $remember = true): int
    {
        return $remember ? self::TTL : self::TTL_SHORT;
    }

    /**
     * Genera un token opaco, lo persiste hasheado y devuelve el plano
     * (el plano se muestra UNA sola vez: es lo que va a localStorage).
     *
     * @return array{token:string, expiresAt:int}
     */
    public function issue(User $user, bool $remember = true): array
    {
        $plain = bin2hex(random_bytes(32)); // 64 chars
        $exp   = time() + $this->ttl($remember);

        $request = service('request');

        $this->tokens->insert([
            'user_id'    => (int)$user->id,
            'token_hash' => $this->hash($plain),
            'user_agent' => mb_substr((string)$request->getUserAgent(), 0, 255) ?: null,
            'ip_address' => $request->getIPAddress(),
            'expires_at' => date('Y-m-d H:i:s', $exp),
            'revoked_at' => null,
        ]);

        $this->enforceSessionLimit((int)$user->id);

        return ['token' => $plain, 'expiresAt' => $exp];
    }

    /**
     * Valida contra la base. Devuelve el mismo payload que antes
     * para no romper filters ni controllers.
     *
     * @return array{sub:int, usr:string, eml:string, rol:string, exp:int, tid:int}
     */
    public function verify(?string $token): array
    {
        if (! $token) {
            throw new UnauthorizedException('Token ausente');
        }

        // Evita pegarle a la base con basura
        if (! preg_match('/^[a-f0-9]{64}$/', $token)) {
            throw new UnauthorizedException('Token malformado');
        }

        $row = $this->tokens->findActiveWithUser($this->hash($token));

        if (! $row) {
            throw new UnauthorizedException('Token inválido');
        }

        if ($row['revoked_at'] !== null) {
            throw new UnauthorizedException('Sesión cerrada');
        }

        $exp = strtotime($row['expires_at']);
        if (time() >= $exp) {
            throw new UnauthorizedException('Token expirado');
        }

        return [
            'sub' => (int)$row['user_id'],
            'usr' => (string)$row['username'],
            'eml' => (string)$row['email'],
            'rol' => strtoupper((string)($row['role'] ?? 'USER')),
            'exp' => $exp,
            'tid' => (int)$row['token_id'],
        ];
    }

    /** Atajo para filters */
    public function verifyFromRequest($request): array
    {
        return $this->verify($request->getHeaderLine(self::HEADER) ?: null);
    }

    /** Logout: revoca el token actual */
    public function revoke(?string $token): void
    {
        if ($token && preg_match('/^[a-f0-9]{64}$/', $token)) {
            $this->tokens->revokeByHash($this->hash($token));
        }
    }

    /** Cerrar sesión en todos los dispositivos */
    public function revokeAll(int $userId, ?int $exceptTokenId = null): void
    {
        $this->tokens->revokeAllForUser($userId, $exceptTokenId);
    }

    public function activeSessions(int $userId): array
    {
        return $this->tokens->activeSessions($userId);
    }

    /**
     * Rotación: emite uno nuevo y mata el viejo.
     * Nunca dejes vivo el token anterior tras un refresh.
     */
    public function rotate(User $user, ?string $oldToken, bool $remember = true): array
    {
        $new = $this->issue($user, $remember);
        $this->revoke($oldToken);

        return $new;
    }

    private function hash(string $plain): string
    {
        return hash('sha256', $plain);
    }

    /** Si supera el máximo de sesiones, revoca las más viejas */
    private function enforceSessionLimit(int $userId): void
    {
        if (self::MAX_SESSIONS <= 0) {
            return;
        }

        $active = $this->tokens->activeSessions($userId);

        if (count($active) <= self::MAX_SESSIONS) {
            return;
        }

        // activeSessions viene DESC por created_at: los sobrantes son los viejos
        foreach (array_slice($active, self::MAX_SESSIONS) as $old) {
            $this->tokens->update($old['id'], ['revoked_at' => date('Y-m-d H:i:s')]);
        }
    }
}