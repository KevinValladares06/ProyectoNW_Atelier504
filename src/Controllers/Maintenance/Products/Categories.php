<?php


namespace Controllers\Maintenance\Products;

use Dao\Products\Categories as CategoriesDAO;
use Views\Renderer;
use Controllers\PublicController;

class Categories extends PublicController
{
    private array $viewData;

    public function __construct()
    {
        $this->viewData = [];
    }

    public function run(): void
    {
        $this->viewData["categories"] = CategoriesDAO::getCategories();
        Renderer::render("maintenance/products/categories", $this->viewData);
    }
}
