<?php

namespace App\Models;

use Config\Database;
use CodeIgniter\Database\BaseConnection;
use App\Entity\Load\Load;
use App\Converter\Load\PrimitiveToLoadConverter;

final class LoadModel
{
    private BaseConnection $database;
    private PrimitiveToLoadConverter $converter;

    public function __construct()
    {
        $this->database = Database::connect();
        $this->converter = new PrimitiveToLoadConverter();
    }

    public function insert(Load $load): Load
    {
        $query = "INSERT INTO loads (type, name, commission, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())";
        $this->database->query($query, [
            $load->getType(),
            $load->getName(),
            $load->getCommission()
        ]);

        $id = $this->database->insertID();

        return new Load(
            $id,
            $load->getType(),
            $load->getName(),
            $load->getCommission(),
            $load->getCreatedAt(),
            $load->getUpdatedAt()
        );
    }

    public function update(Load $load): Load
    {
        $query = "UPDATE loads SET type = ?, name = ?, commission = ?, updated_at = NOW() WHERE id = ?";
        $this->database->query($query, [
            $load->getType(),
            $load->getName(),
            $load->getCommission(),
            $load->getId()
        ]);

        return clone $load;
    }

    public function find(int $id): ?Load
    {
        $query = "SELECT L.id, L.type, L.name, L.commission, L.created_at, L.updated_at FROM loads L WHERE L.id = ?";
        $result = $this->database->query($query, [$id]);

        $primitive = $result->getRow();

        if (is_null($primitive)) {
            return null;
        }

        return $this->converter->convert($primitive);
    }

    public function search(): array
    {
        $query = "SELECT L.id, L.type, L.name, L.commission, L.created_at, L.updated_at FROM loads L";
        $result = $this->database->query($query);

        $primitives = $result->getResult();

        $entities = [];
        foreach ($primitives as $primitive) {
            $entities[] = $this->converter->convert($primitive);
        }

        return $entities;
    }

    public function delete(int $id): void
    {
        $query = "DELETE FROM loads WHERE id = ?";
        $this->database->query($query, [$id]);
    }
}
