<?php

namespace App\Models;

use Config\Database;
use CodeIgniter\Database\BaseConnection;
use App\Entity\Loads;

final class LoadsModel
{
    private BaseConnection $database;

    public function __construct()
    {
        $this->database = Database::connect();
    }

    public function insert(string $type, string $name, float $commission): int
    {
        $query = "INSERT INTO loads (type, name, commission, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())";
        $this->database->query($query, [$type, $name, $commission]);

        return (int) $this->database->insertID();
    }

    public function update(string $type, string $name, float $commission, int $id): void
    {
        $query = "UPDATE loads SET type = ?, name = ?, commission = ?, updated_at = NOW() WHERE id = ?";
        $this->database->query($query, [$type, $name, $commission, $id]);
    }

    public function find(int $id): ?object
    {
        $query = "SELECT L.id, L.type, L.name, L.commission, L.created_at, L.updated_at FROM loads L WHERE L.id = ?";
        $result = $this->database->query($query, [$id]);

        return $result->getRow(0, Loads::class);
    }

    public function search(): array
    {
        $query = "SELECT L.id, L.type, L.name, L.commission, L.created_at, L.updated_at FROM loads L";
        $result = $this->database->query($query);

        return $result->getResult(Loads::class);
    }

    public function delete(int $id): void
    {
        $query = "DELETE FROM loads WHERE id = ?";
        $this->database->query($query, [$id]);
    }
}

