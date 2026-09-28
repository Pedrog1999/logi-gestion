<?php

namespace App\Models;

use App\Entities\UserEntity;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = UserEntity::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['username', 'email', 'password', 'role', 'active'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function findByUsername(string $username): ?UserEntity
    {
        return $this->where('username', $username)->first();
    }

    public function findByEmail(string $email): ?UserEntity
    {
        return $this->where('email', $email)->first();
    }

    /** @return UserEntity[] */
    public function findAllByActive(?bool $active = null): array
    {
        if ($active !== null) {
            $this->where('active', $active ? 1 : 0);
        }

        return $this->orderBy('id', 'ASC')->findAll();
    }

    public function usernameExists(string $username, ?int $exceptId = null): bool
    {
        $this->where('username', $username);

        if ($exceptId !== null) {
            $this->where('id !=', $exceptId);
        }

        return $this->countAllResults() > 0;
    }

    public function emailExists(string $email, ?int $exceptId = null): bool
    {
        $this->where('email', $email);

        if ($exceptId !== null) {
            $this->where('id !=', $exceptId);
        }

        return $this->countAllResults() > 0;
    }
}