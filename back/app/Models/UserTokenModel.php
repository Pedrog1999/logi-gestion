<?php

namespace App\Models;

use CodeIgniter\Model;

class UserTokenModel extends Model
{
    protected $table         = 'user_tokens';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'user_id',
        'token_hash',
        'user_agent',
        'ip_address',
        'expires_at',
        'revoked_at',
    ];

    /**
     * Busca el token vivo y trae de una los datos del usuario.
     * Un solo query: evita el SELECT extra a users en cada request.
     */
    public function findActiveWithUser(string $hash): ?array
    {
        return $this->db->table($this->table . ' t')
            ->select('t.id AS token_id, t.user_id, t.expires_at, t.revoked_at,
                      u.username, u.email, u.role')
            ->join('users u', 'u.id = t.user_id')
            ->where('t.token_hash', $hash)
            ->get()
            ->getRowArray();
    }

    public function revokeByHash(string $hash): void
    {
        $this->where('token_hash', $hash)
             ->where('revoked_at', null)
             ->set('revoked_at', date('Y-m-d H:i:s'))
             ->update();
    }

    /** Cierra sesión en todos los dispositivos */
    public function revokeAllForUser(int $userId, ?int $exceptTokenId = null): void
    {
        $builder = $this->where('user_id', $userId)->where('revoked_at', null);

        if ($exceptTokenId !== null) {
            $builder->where('id !=', $exceptTokenId);
        }

        $builder->set('revoked_at', date('Y-m-d H:i:s'))->update();
    }

    /** @return array sesiones activas del usuario */
    public function activeSessions(int $userId): array
    {
        return $this->select('id, user_agent, ip_address, expires_at, created_at')
            ->where('user_id', $userId)
            ->where('revoked_at', null)
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /** Borra expirados y revocados viejos.*/
    public function purge(int $graceDays = 7): int
    {
        $limit = date('Y-m-d H:i:s', strtotime("-{$graceDays} days"));

        $this->groupStart()
                ->where('expires_at <', $limit)
                ->orWhere('revoked_at <', $limit)
             ->groupEnd()
             ->delete();

        return $this->db->affectedRows();
    }
}