<?php 

namespace App\Models;

use App\Converter\Company\PrimitiveToCompanyConverter;
use App\Dto\Request\Company\CompanyFilterRequest;
use App\Entity\Company\Company;
use Config\Database;
use CodeIgniter\Database\BaseConnection;

final class CompanyModel {

    private BaseConnection $database;
    private PrimitiveToCompanyConverter $converter;

    public function __construct() {
        $this->database = Database::connect();
        $this->converter = new PrimitiveToCompanyConverter();
    }

    public function insert(Company $company): Company
    {
        $query = "INSERT INTO companies (business_name, cuit, phone, email, address, created_at) VALUES (?, ?, ?, ?, ?, ?) ";

        $this->database->query($query, [
            $company->getBusinessName(),
            $company->getCuit(),
            $company->getPhone(),
            $company->getEmail(),
            $company->getAddress(),
            $company->getCreatedAt()->format("Y-m-d H:i:s")
        ]);

        $id = $this->database->insertID();

        return new Company(
            $id,
            $company->getBusinessName(),
            $company->getCuit(),
            $company->getPhone(),
            $company->getEmail(),
            $company->getAddress(),
            $company->getCreatedAt()
        );
    }

    public function update(Company $company): Company
    {
        $query = "UPDATE companies SET business_name = ?, cuit = ?, phone = ?, email = ?, address = ? WHERE id = ?";

        $this->database->query($query, [
            $company->getBusinessName(),
            $company->getCuit(),
            $company->getPhone(),
            $company->getEmail(),
            $company->getAddress(),
            $company->getId()
        ]);

        return $company;
    }

    public function find(int $id): ?Company
    {
        $query = "SELECT C.id, C.business_name, C.cuit, C.phone, C.email, C.address, C.created_at FROM companies C WHERE C.id = ? ";
        $result = $this->database->query($query, [$id]);

        $primitive = $result->getRow();

        if (is_null($primitive)) {
            return null;
        }

        $company = $this->converter->convert($primitive);

        return $company;
    }

    /**
     * @return Company[]
     */
    public function search(CompanyFilterRequest $request): array
    {
        $parameters = [];

        $selectQuery = "SELECT C.id, C.business_name, C.cuit, C.phone, C.email, C.address, C.created_at ";

        $fromQuery = "FROM companies C ";
        $whereQuery = "WHERE 1 = 1 ";
        if ($request->hasBusinessName()) {
            $whereQuery .= " AND C.business_name LIKE ? ";
            $businessName = $request->getBusinessName();
            $parameters[] = "%$businessName%";
        }
        if ($request->hasCuit()) {
            $whereQuery .= " AND C.cuit LIKE ? ";
            $cuit = $request->getCuit();
            $parameters[] = "%$cuit%";
        }
        if ($request->hasEmail()) {
            $whereQuery .= " AND C.email LIKE ? ";
            $email = $request->getEmail();
            $parameters[] = "%$email%";
        }
        if ($request->hasAddress()) {
            $whereQuery .= " AND C.address LIKE ? ";
            $address = $request->getAddress();
            $parameters[] = "%$address%";
        }

        $orderQuery = "ORDER BY C.id ASC ";

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
        $query = "DELETE FROM companies WHERE id = ?";
        $this->database->query($query, [$id]);
    }
}