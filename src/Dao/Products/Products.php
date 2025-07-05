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
                "productDescription" => "Descripcion del producto 1",
                "productImgUrl" => "https://via.placeholder.com/150",
                "productPrice" => 100.00
            ],
            [
                "productId" => 2,
                "productName" => "Producto 2",
                "productDescription" => "Descripcion del producto 2",
                "productImgUrl" => "https://via.placeholder.com/150",
                "productPrice" => 120.00
            ],
            [
                "productId" => 3,
                "productName" => "Producto 3",
                "productDescription" => "Descripcion del producto 3",
                "productImgUrl" => "https://via.placeholder.com/150",
                "productPrice" => 70.00
            ]
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
            "productDescription" => "Descripción del producto nuevo 99",
            "productImgUrl" => "https://via.placeholder.com/150",
            "productPrice" => 50.00
          ],
          [
            "productId" => 100,
            "productName" => "Producto 100",
            "productDescription" => "Descripción del producto nuevo 100",
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

    public static function getProducts(
        string $partialName = "",
        string $status = "",
        string $orderBy = "",
        bool $orderDescending = false,
        int $page = 0,
        int $itemsPerPage = 10
    ) {
        $sqlstr = "SELECT p.productId, p.productName, p.productDescription, p.productPrice, p.productImgUrl, p.productStatus, case WHEN p.productStatus = 'ACT' THEN 'Activo' WHEN p.productStatus = 'INA' THEN 'Inactivo' ELSE 'Sin Asignar' END as productStatusDsc 
    FROM products p";
        $sqlstrCount = "SELECT COUNT(*) as count FROM products p";
        $conditions = [];
        $params = [];
        if ($partialName != "") {
            $conditions[] = "p.productName LIKE :partialName";
            $params["partialName"] = "%" . $partialName . "%";
        }
        if (!in_array($status, ["ACT", "INA", ""])) {
            throw new \Exception("Error Processing Request Status has invalid value");
        }
        if ($status != "") {
            $conditions[] = "p.productStatus = :status";
            $params["status"] = $status;
        }
        if (count($conditions) > 0) {
            $sqlstr .= " WHERE " . implode(" AND ", $conditions);
            $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
        }
        if (!in_array($orderBy, ["productId", "productName", "productPrice", ""])) {
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
        $sqlstr .= " LIMIT " . $page * $itemsPerPage . ", " . $itemsPerPage;

        $registros = self::obtenerRegistros($sqlstr, $params);
        return ["products" => $registros, "total" => $numeroDeRegistros, "page" => $page, "itemsPerPage" => $itemsPerPage];
    }

    public static function getProductById(int $productId)
    {
        $sqlstr = "SELECT p.productId, p.productName, p.productDescription, p.productPrice, p.productImgUrl, p.productStatus FROM products p WHERE p.productId = :productId";
        $params = ["productId" => $productId];
        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function insertProduct(
        string $productName,
        string $productDescription,
        float $productPrice,
        string $productImgUrl,
        string $productStatus
    ) {
        $sqlstr = "INSERT INTO products (productName, productDescription, productPrice, productImgUrl, productStatus) VALUES (:productName, :productDescription, :productPrice, :productImgUrl, :productStatus)";
        $params = [
            "productName" => $productName,
            "productDescription" => $productDescription,
            "productPrice" => $productPrice,
            "productImgUrl" => $productImgUrl,
            "productStatus" => $productStatus
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function updateProduct(
        int $productId,
        string $productName,
        string $productDescription,
        float $productPrice,
        string $productImgUrl,
        string $productStatus
    ) {
        $sqlstr = "UPDATE products SET productName = :productName, productDescription = :productDescription, productPrice = :productPrice, productImgUrl = :productImgUrl, productStatus = :productStatus WHERE productId = :productId";
        $params = [
            "productId" => $productId,
            "productName" => $productName,
            "productDescription" => $productDescription,
            "productPrice" => $productPrice,
            "productImgUrl" => $productImgUrl,
            "productStatus" => $productStatus
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function deleteProduct(int $productId)
    {
        $sqlstr = "DELETE FROM products WHERE productId = :productId";
        $params = ["productId" => $productId];
        return self::executeNonQuery($sqlstr, $params);
    }
}
