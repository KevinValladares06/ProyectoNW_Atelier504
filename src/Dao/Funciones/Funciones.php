<?php

namespace Dao\Funciones;

use Dao\Table;

class Funciones extends Table
{
    public static function getAll(): array
    {
        $sqlstr = "SELECT * FROM funciones;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function getById(string $id): array
    {
        $sqlstr = "SELECT * FROM funciones WHERE fncod = :fncod;";
        return self::obtenerUnRegistro($sqlstr, ['fncod' => $id]);
    }

    public static function insertFunciones(
        string $fncod,
        string $fndsc,
        string $fnest,
        string $fntyp
    ): int {
        $sqlstr = "INSERT INTO funciones (fncod, fndsc, fnest, fntyp)
                   VALUES (:fncod, :fndsc, :fnest, :fntyp);";

        return self::executeNonQuery($sqlstr, [
            "fncod" => $fncod,
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp
        ]);
    }

    public static function updateFunciones(
        string $fncod,
        string $fndsc,
        string $fnest,
        string $fntyp
    ): int {
        $sqlstr = "UPDATE funciones
                   SET fndsc = :fndsc, fnest = :fnest, fntyp = :fntyp
                   WHERE fncod = :fncod;";

        return self::executeNonQuery($sqlstr, [
            "fncod" => $fncod,
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp
        ]);
    }

    public static function deleteFunciones(string $fncod): int
    {
        $sqlstr = "DELETE FROM funciones WHERE fncod = :fncod;";
        return self::executeNonQuery($sqlstr, ['fncod' => $fncod]);
    }

    public static function getFunciones(
        string $partialName = "",
        string $orderBy = "",
        bool $orderDescending = false,
        int $page = 0,
        int $itemsPerPage = 10
    ): array {
        $sqlstr = "SELECT * FROM funciones";
        $sqlstrCount = "SELECT COUNT(*) as total FROM funciones";
        $conditions = [];
        $params = [];

        if ($partialName !== "") {
            $conditions[] = "fncod LIKE :partialName";
            $params["partialName"] = "%" . $partialName . "%";
        }

        if (!empty($conditions)) {
            $sqlstr .= " WHERE " . implode(" AND ", $conditions);
            $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
        }

        if (!in_array($orderBy, ["fncod", "fndsc", "fnest", "fntyp", ""])) {
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
            "funciones" => $registros,
            "total" => $totalRegistros,
            "page" => $page,
            "itemsPerPage" => $itemsPerPage
        ];
    }
}
