<?php

namespace Dao\Users;

use Dao\Table;

class Users extends Table
{
    public static function getUsers(
        string $partialName = "",
        string $status = "",
        string $orderBy = "",
        bool $orderDescending = false,
        int $page = 0,
        int $itemsPerPage = 10
    ) {
        $sqlstr = "SELECT 
            u.usercod,
            u.useremail,
            u.username,
            u.userfching,
            u.userpswdest,
            u.userpswdexp,
            u.userest,
            u.useractcod,
            u.userpswdchg,
            u.usertipo,
            CASE 
                WHEN u.userest = 'ACT' THEN 'Activo' 
                WHEN u.userest = 'INA' THEN 'Inactivo' 
                ELSE 'Sin Asignar' 
            END as userestDsc,
            CASE 
                WHEN u.userpswdest = 'ACT' THEN 'Activo'
                WHEN u.userpswdest = 'INA' THEN 'Inactivo'
                WHEN u.userpswdest = 'EXP' THEN 'Expirado'
                ELSE 'Sin Asignar'
            END as userpswdestDsc,
            CASE 
                WHEN u.usertipo = 'NOR' THEN 'Normal'
                WHEN u.usertipo = 'CON' THEN 'Consultor'
                WHEN u.usertipo = 'CLI' THEN 'Cliente'
                ELSE 'Sin Asignar'
            END as usertipoDsc
        FROM usuario u";

        $sqlstrCount = "SELECT COUNT(*) as count FROM usuario u";

        $conditions = [];
        $params = [];

        if ($partialName != "") {
            $conditions[] = "u.username LIKE :partialName";
            $params["partialName"] = "%" . $partialName . "%";
        }

        if (!in_array($status, ["ACT", "INA", ""])) {
            throw new \Exception("Error Processing Request Status has invalid value");
        }
        if ($status != "") {
            $conditions[] = "u.userest = :status";
            $params["status"] = $status;
        }

        if (count($conditions) > 0) {
            $sqlstr .= " WHERE " . implode(" AND ", $conditions);
            $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
        }

        $validOrderBy = ["usercod", "username", "useremail", "userest"];
        if (!in_array($orderBy, $validOrderBy) && $orderBy != "") {
            throw new \Exception("Error Processing Request OrderBy has invalid value");
        }
        if ($orderBy != "") {
            $sqlstr .= " ORDER BY " . $orderBy;
            if ($orderDescending) {
                $sqlstr .= " DESC";
            }
        }

        $numeroDeRegistros = self::obtenerUnRegistro($sqlstrCount, $params)["count"];
        $pagesCount = ceil($numeroDeRegistros / $itemsPerPage);
        if ($page > $pagesCount - 1) {
            $page = $pagesCount - 1;
        }
        $sqlstr .= " LIMIT " . ($page * $itemsPerPage) . ", " . $itemsPerPage;

        $registros = self::obtenerRegistros($sqlstr, $params);
        return [
            "users" => $registros,
            "total" => $numeroDeRegistros,
            "page" => $page,
            "itemsPerPage" => $itemsPerPage
        ];
    }

    public static function getUserById(int $usercod)
    {
        $sqlstr = "SELECT 
            u.usercod,
            u.useremail,
            u.username,
            u.userpswd,
            u.userfching,
            u.userpswdest,
            u.userpswdexp,
            u.userest,
            u.useractcod,
            u.userpswdchg,
            u.usertipo
        FROM usuario u WHERE u.usercod = :usercod";
        $params = ["usercod" => $usercod];
        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function insertUser(
        string $useremail,
        string $username,
        string $userpswd,
        $userfching,
        string $userpswdest,
        $userpswdexp,
        string $userest,
        string $useractcod,
        string $userpswdchg,
        string $usertipo
    ) {
        $sqlstr = "INSERT INTO usuario 
            (useremail, username, userpswd, userfching, userpswdest, userpswdexp, userest, useractcod, userpswdchg, usertipo)
            VALUES 
            (:useremail, :username, :userpswd, :userfching, :userpswdest, :userpswdexp, :userest, :useractcod, :userpswdchg, :usertipo)";
        $params = [
            "useremail" => $useremail,
            "username" => $username,
            "userpswd" => $userpswd,
            "userfching" => $userfching,
            "userpswdest" => $userpswdest,
            "userpswdexp" => $userpswdexp,
            "userest" => $userest,
            "useractcod" => $useractcod,
            "userpswdchg" => $userpswdchg,
            "usertipo" => $usertipo
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function updateUser(
        int $usercod,
        string $useremail,
        string $username,
        string $userpswd,
        $userfching,
        string $userpswdest,
        $userpswdexp,
        string $userest,
        string $useractcod,
        string $userpswdchg,
        string $usertipo
    ) {
        $sqlstr = "UPDATE usuario SET 
            useremail = :useremail,
            username = :username,
            userpswd = :userpswd,
            userfching = :userfching,
            userpswdest = :userpswdest,
            userpswdexp = :userpswdexp,
            userest = :userest,
            useractcod = :useractcod,
            userpswdchg = :userpswdchg,
            usertipo = :usertipo
        WHERE usercod = :usercod";
        $params = [
            "usercod" => $usercod,
            "useremail" => $useremail,
            "username" => $username,
            "userpswd" => $userpswd,
            "userfching" => $userfching,
            "userpswdest" => $userpswdest,
            "userpswdexp" => $userpswdexp,
            "userest" => $userest,
            "useractcod" => $useractcod,
            "userpswdchg" => $userpswdchg,
            "usertipo" => $usertipo
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function deleteUser(int $usercod)
    {
        $sqlstr = "DELETE FROM usuario WHERE usercod = :usercod";
        $params = ["usercod" => $usercod];
        return self::executeNonQuery($sqlstr, $params);
    }
}
