<?php


namespace Dao\Products;

use Dao\Table;


class Categories extends table
{
    public static function getCategories()
    {
        $sqlstr = "SELECT * FROM categorias";
        return self::obtenerRegistros(
            $sqlstr,
            []
        );
    }


    public static function getCategoriesById(int $id): array
    {
        $sqlstr = "SELECT * FROM categorias where id = :idCategoria;";
        return self::obtenerUnRegistro($sqlstr, ["idCategoria" => $id]);
    }
}
