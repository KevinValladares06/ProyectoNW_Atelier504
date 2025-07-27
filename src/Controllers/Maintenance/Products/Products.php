<?php

namespace Controllers\Mantenimientos\Productos;

use Dao\Mantenimientos\Productos\Products as ProductsDao;
use Controllers\PublicController;
use Views\Renderer;

class Products extends PublicController
{
    public function run(): void
    {
        $viewData["rows"] = ProductsDao::getAll();
        Renderer::render("mantenimientos/productos/products_list", $viewData);
    }
}
