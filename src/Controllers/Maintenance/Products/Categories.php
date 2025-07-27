<?php

namespace Controllers\Maintenance\Products;

use Controllers\PrivateController;
use Dao\Products\Categories as CategoriesDAO;
use Views\Renderer;

class Categories extends PrivateController
{
    private array $viewData;
    public function __construct()
    {
        parent::__construct();
        $this->viewData = [];
        $this->viewData["isNewEnabled"] =
            parent::isFeatureAutorized($this->name . "\\new");
        $this->viewData["isUpdateEnabled"] =
            parent::isFeatureAutorized($this->name . "\update");
        $this->viewData["isDeleteEnabled"] =
            parent::isFeatureAutorized($this->name . "\delete");
    }

    public function run(): void
    {
        $this->viewData["categories"] = CategoriesDAO::getCategories();
        Renderer::render("maintenance/products/categories", $this->viewData);
    }
}
