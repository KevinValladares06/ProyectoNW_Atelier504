<?php

namespace Dao\Products;

use Dao\Table;

class Categories extends Table
{

    public static function getCategories(): array
    {
        $sqlstr = "SELECT * FROM categorias;";
        return self::obtenerRegistros(
            $sqlstr,
            []
        );
    }

    public static function getCategoriesById(int $id)
    {
        $sqlstr = "SELECT * from categorias where id = :idCategoria;";
        return self::obtenerUnRegistro($sqlstr, ["idCategoria" => $id]);
    }

    public static function newCategory(string $categoria, string $estado)
    {
        $sqlstr = "INSERT INTO categorias (categoria, estado) values (:categoria, :estado);";
        return self::executeNonQuery(
            $sqlstr,
            [
                "categoria" => $categoria,
                "estado" => $estado
            ]
        );
    }

    public static function updateCategory(int $id, string $categoria, string $estado)
    {
        $sqlstr = "UPDATE categorias set categoria = :categoria, estado = :estado where id = :id;";
        return self::executeNonQuery(
            $sqlstr,
            [
                "categoria" => $categoria,
                "estado" => $estado,
                "id" => $id
            ]
        );
    }

    public static function deleteCategory(int $id)
    {
        $sqlstr = "DELETE FROM categorias where id = :id;";
        return self::executeNonQuery(
            $sqlstr,
            [
                "id" => $id
            ]
        );
    }
}
