<?php

namespace Dao\Products;

use Dao\Table;

class Products extends Table
{
    public static function getFeaturedProducts()
    {
        $sqlstr = "SELECT p.productId, p.productName, p.productDescription, p.productPrice, p.productImgUrl, p.productStatus FROM products p INNER JOIN highlights h ON p.productId = h.productId WHERE h.highlightStart <= NOW() AND h.highlightEnd >= NOW()";
        $params = [];
        $registros = self::obtenerRegistros($sqlstr, $params);
        return $registros;
        /*return [

            [
                "productId" => 1,
                "productName" => "Producto 1",
                "productDescription" => "Descripción del producto 1",
                "productImgUrl" => "https://via.placeholder.com/150",
                "productUnitPrice" => 100.00
            ],
            [
                "productId" => 2,
                "productName" => "Producto 2",
                "productDescription" => "Descripción del producto 2",
                "productImgUrl" => "https://via.placeholder.com/150",
                "productUnitPrice" => 120.00
            ],

            [
                "productId" => 3,
                "productName" => "Producto 3",
                "productDescription" => "Descripción del producto 3",
                "productImgUrl" => "https://via.placeholder.com/150",
                "productUnitPrice" => 70.00
            ],

        ];*/
    }

    public static function getNewProducts()
    {
        $sqlstr = "SELECT p.productId, p.productName, p.productDescription, p.productPrice, p.productImgUrl, p.productStatus FROM products p WHERE p.productStatus = 'ACT' ORDER BY p.productId DESC LIMIT 3";
        $params = [];
        $registros = self::obtenerRegistros($sqlstr, $params);
        return $registros;
        /*return [
            [
                "productId" => 99,
                "productName" => "Producto 99",
                "ProductoDescription" => "Descripción del producto Nuevo 99",
                "productImgUrl" => "https://via.placeholder.com/150",
                "productPrice" => 50.00
            ],
            [
                "productId" => 100,
                "productName" => "Producto 100",
                "ProductoDescription" => "Descripción del producto Nuevo 100",
                "productImgUrl" => "https://via.placeholder.com/150",
                "productPrice" => 130.00
            ]
        ];*/
    }

    public static function getDailyDeals()
    {
        $sqlstr = "SELECT p.productId, p.productName, p.productDescription, s.salePrice as productPrice, p.productImgUrl, p.productStatus FROM products p INNER JOIN sales s ON p.productId = s.productId WHERE s.saleStart <= NOW() AND s.saleEnd >= NOW()";
        $params = [];
        $registros = self::obtenerRegistros($sqlstr, $params);
        return $registros;
        /*return [
            [
                "productId" => 73,
                "productName" => "Producto 73",
                "productDescription" => "Descripción del producto 73",
                "productImgUrl" => "https://via.placeholder.com/150",
                "productPrice" => 10.00
            ],
            [
                "productId" => 15,
                "productName" => "Producto 15",
                "productDescription" => "Descripción del producto 15",
                "productImgUrl" => "https://via.placeholder.com/150",
                "productPrice" => 13.00
            ],
            [
                "productId" => 10,
                "productName" => "Producto 10",
                "productDescription" => "Descripción del producto 10",
                "productImgUrl" => "https://via.placeholder.com/150",
                "productPrice" => 20.00
            ]

        ];*/
    }
}
