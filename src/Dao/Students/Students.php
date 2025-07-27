<?php

namespace Dao\Students;

use Dao\Table;

class Students extends Table
{
    public static function getStudents(
        string $partialName = "",
        string $specialty = "",
        string $orderBy = "",
        bool $orderDescending = false,
        int $page = 0,
        int $itemsPerPage = 10
    ) {
        $sqlstr = "SELECT s.id_estudiante, s.nombre, s.apellido, s.edad, s.especialidad FROM EstudianteCienciasComputacionales s";
        $sqlstrCount = "SELECT COUNT(*) as count FROM EstudianteCienciasComputacionales s";
        $conditions = [];
        $params = [];

        if ($partialName !== "") {
            $conditions[] = "s.nombre LIKE :partialName";
            $params["partialName"] = "%" . $partialName . "%";
        }

        if ($specialty !== "") {
            $conditions[] = "s.especialidad LIKE :specialty";
            $params["specialty"] = "%" . $specialty . "%";
        }

        if (count($conditions) > 0) {
            $sqlstr .= " WHERE " . implode(" AND ", $conditions);
            $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
        }

        if (!in_array($orderBy, ["id_estudiante", "nombre", "apellido", "edad", "especialidad", ""])) {
            throw new \Exception("El parámetro 'orderBy' tiene un valor no permitido");
        }

        if ($orderBy !== "") {
            $sqlstr .= " ORDER BY " . $orderBy;
            if ($orderDescending) {
                $sqlstr .= " DESC";
            }
        }

        error_log("SQL Consulta: " . $sqlstr);
        error_log("Parámetros consulta: " . print_r($params, true));

        $numeroDeRegistros = self::obtenerUnRegistro($sqlstrCount, $params)["count"];
        $pagesCount = ceil($numeroDeRegistros / $itemsPerPage);

        if ($pagesCount === 0) {
            $page = 0;
        } else {
            if ($page < 0) {
                $page = 0;
            } elseif ($page > $pagesCount - 1) {
                $page = $pagesCount - 1;
            }
        }

        $offset = $page * $itemsPerPage;
        if ($offset < 0) {
            $offset = 0;
        }

        $sqlstr .= " LIMIT " . $offset . ", " . $itemsPerPage;

        $registros = self::obtenerRegistros($sqlstr, $params);

        error_log("Registros obtenidos: " . count($registros));

        return [
            "students" => $registros,
            "total" => $numeroDeRegistros,
            "page" => $page,
            "itemsPerPage" => $itemsPerPage
        ];
    }

    public static function getStudentById(int $id_estudiante)
    {
        $sqlstr = "SELECT * FROM EstudianteCienciasComputacionales WHERE id_estudiante = :id_estudiante";
        $params = ["id_estudiante" => $id_estudiante];
        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function insertStudent(
        string $nombre,
        string $apellido,
        int $edad,
        string $especialidad
    ) {
        $sqlstr = "INSERT INTO EstudianteCienciasComputacionales (nombre, apellido, edad, especialidad) 
                   VALUES (:nombre, :apellido, :edad, :especialidad)";
        $params = [
            "nombre" => $nombre,
            "apellido" => $apellido,
            "edad" => $edad,
            "especialidad" => $especialidad
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function updateStudent(
        int $id_estudiante,
        string $nombre,
        string $apellido,
        int $edad,
        string $especialidad
    ) {
        $sqlstr = "UPDATE EstudianteCienciasComputacionales 
                   SET nombre = :nombre, apellido = :apellido, edad = :edad, especialidad = :especialidad 
                   WHERE id_estudiante = :id_estudiante";
        $params = [
            "id_estudiante" => $id_estudiante,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "edad" => $edad,
            "especialidad" => $especialidad
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function deleteStudent(int $id_estudiante)
    {
        $sqlstr = "DELETE FROM EstudianteCienciasComputacionales WHERE id_estudiante = :id_estudiante";
        $params = ["id_estudiante" => $id_estudiante];
        return self::executeNonQuery($sqlstr, $params);
    }
}
