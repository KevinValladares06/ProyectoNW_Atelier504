<?php

namespace Dao\Roles;

use Dao\Table;

class Roles extends Table
{
    public static function getAll(): array
    {
        $sqlstr = "SELECT * FROM roles;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getById(string $id): array
    {
        $sqlstr = "SELECT * FROM roles WHERE rolescod = :rolescod;";
        return self::obtenerUnRegistro($sqlstr, ['rolescod' => $id]);
    }

    public static function insertRoles(
        string $rolescod,
        string $rolesdsc,
        string $rolesest
    ): int {
        $sqlstr = "INSERT INTO roles (rolescod, rolesdsc, rolesest)
                   VALUES (:rolescod, :rolesdsc, :rolesest);";

        return self::executeNonQuery($sqlstr, [
            "rolescod" => $rolescod,
            "rolesdsc" => $rolesdsc,
            "rolesest" => $rolesest
        ]);
    }

    public static function updateRoles(
        string $rolescod,
        string $rolesdsc,
        string $rolesest
    ): int {
        $sqlstr = "UPDATE roles
                   SET rolesdsc = :rolesdsc,
                       rolesest = :rolesest
                   WHERE rolescod = :rolescod;";

        return self::executeNonQuery($sqlstr, [
            "rolescod" => $rolescod,
            "rolesdsc" => $rolesdsc,
            "rolesest" => $rolesest
        ]);
    }

    public static function deleteRoles(string $rolescod): int
    {
        $sqlstr = "DELETE FROM roles WHERE rolescod = :rolescod;";
        return self::executeNonQuery($sqlstr, ['rolescod' => $rolescod]);
    }

    public static function getRoles(
        string $partialName = "",
        string $orderBy = "",
        bool $orderDescending = false,
        int $page = 0,
        int $itemsPerPage = 10
    ): array {
        $sqlstr = "SELECT * FROM roles";
        $sqlstrCount = "SELECT COUNT(*) as total FROM roles";
        $conditions = [];
        $params = [];

        if ($partialName !== "") {
            $conditions[] = "rolesdsc LIKE :partialName";
            $params["partialName"] = "%" . $partialName . "%";
        }

        if (!empty($conditions)) {
            $sqlstr .= " WHERE " . implode(" AND ", $conditions);
            $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
        }

        if (!in_array($orderBy, ["rolescod", "rolesdsc", "rolesest", ""])) {
            throw new \Exception("Campo de ordenamiento inválido");
        }

        if ($orderBy !== "") {
            $sqlstr .= " ORDER BY " . $orderBy;
            if ($orderDescending) {
                $sqlstr .= " DESC";
            }
        }

        $totalRegistros = self::obtenerUnRegistro($sqlstrCount, $params)["total"];
        $sqlstr .= " LIMIT " . $page * $itemsPerPage . ", " . $itemsPerPage;
        $registros = self::obtenerRegistros($sqlstr, $params);

        return [
            "roles" => $registros,
            "total" => $totalRegistros,
            "page" => $page,
            "itemsPerPage" => $itemsPerPage
        ];
    }
}
