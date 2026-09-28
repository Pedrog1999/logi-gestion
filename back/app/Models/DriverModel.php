<?php 

namespace App\Models;

use App\Converter\Driver\PrimitiveToDriverConverter;
use App\Dto\Request\Driver\DriverFilterRequest;
use App\Entity\Driver\Driver;
use Config\Database;
use CodeIgniter\Database\BaseConnection;

final class DriverModel {

    private BaseConnection $database;
    private PrimitiveToDriverConverter $converter;

    public function __construct() {
        $this->database = Database::connect();
        $this->converter = new PrimitiveToDriverConverter();
    }

    public function insert(Driver $driver): Driver
    {
        $query = "INSERT INTO drivers (name, surname, cuil, phone, email, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?) ";

        $this->database->query($query, [
            $driver->getName(),
            $driver->getSurname(),
            $driver->getCuil(),
            $driver->getPhone(),
            $driver->getEmail(),
            $driver->getStatus(),
            $driver->getCreatedAt()->format("Y-m-d H:i:s")
        ]);

        $id = $this->database->insertID();

        return new Driver(
            $id,
            $driver->getName(),
            $driver->getSurname(),
            $driver->getCuil(),
            $driver->getPhone(),
            $driver->getEmail(),
            $driver->getStatus(),
            $driver->getCreatedAt()
        );
    }

    public function update(Driver $driver): Driver
    {
        $query = "UPDATE drivers SET name = ?, surname = ?, cuil = ?, phone = ?, email = ?, status = ? WHERE id = ?";

        $this->database->query($query, [
            $driver->getName(),
            $driver->getSurname(),
            $driver->getCuil(),
            $driver->getPhone(),
            $driver->getEmail(),
            $driver->getStatus(),
            $driver->getId()
        ]);

        return $driver;
    }

    public function find(int $id): ?Driver
    {
        $query = "SELECT D.id, D.name, D.surname, D.cuil, D.phone, D.email, D.status, D.created_at FROM drivers D WHERE D.id = ? ";
        $result = $this->database->query($query, [$id]);

        $primitive = $result->getRow();

        if (is_null($primitive)) {
            return null;
        }

        $driver = $this->converter->convert($primitive);

        return $driver;
    }

    /**
     * @return Driver[]
     */
    public function search(DriverFilterRequest $request): array
    {
        $parameters = [];

        $selectQuery = "SELECT D.id, D.name, D.surname, D.cuil, D.phone, D.email, D.status, D.created_at ";

        $fromQuery = "FROM drivers D ";
        $whereQuery = "WHERE 1 = 1 ";
        if ($request->hasName()) {
            $whereQuery .= " AND D.name LIKE ? ";
            $name = $request->getName();
            $parameters[] = "%$name%";
        }
        if ($request->hasSurname()) {
            $whereQuery .= " AND D.surname LIKE ? ";
            $surname = $request->getSurname();
            $parameters[] = "%$surname%";
        }
        if ($request->hasCuil()) {
            $whereQuery .= " AND D.cuil LIKE ? ";
            $cuil = $request->getCuil();
            $parameters[] = "%$cuil%";
        }
        if ($request->hasEmail()) {
            $whereQuery .= " AND D.email LIKE ? ";
            $email = $request->getEmail();
            $parameters[] = "%$email%";
        }
        if ($request->hasStatus()) {
            $whereQuery .= " AND D.status = ? ";
            $parameters[] = $request->getStatus();
        }

        $orderQuery = "ORDER BY D.id ASC ";

        $paginationQuery = "LIMIT ?, ? ";
        $parameters[] = $request->getPagination()->getOffset();
        $parameters[] = $request->getPagination()->getLimit();

        $fullQuery = $selectQuery . $fromQuery . $whereQuery . $orderQuery . $paginationQuery;

        $result = $this->database->query($fullQuery, $parameters);

        $primitives = $result->getResult();

        $entities = [];
        foreach ($primitives as $primitive) {
            $entities[] = $this->converter->convert($primitive);
        }

        return $entities;
    }

    public function delete(int $id): void
    {
        $query = "DELETE FROM drivers WHERE id = ?";
        $this->database->query($query, [$id]);
    }
}