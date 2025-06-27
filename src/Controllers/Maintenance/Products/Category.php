<?php


namespace Controllers\Maintenance\Products;

use Dao\Products\Categories as CategoriesDAO;
use Views\Renderer;
use Controllers\PublicController;

class Category extends PublicController
{
    private array $viewData;

    public function __construct()
    {
        $this->viewData = [];
    }

    public function run(): void
    {
        if (isset($_GET["mode"])) {
            $this->viewData["mode"] = $_GET["mode"];
            if ($this->viewData["mode"] != "INS") {
                $this->viewData["id"] = intval($_GET["id"]);
            }
            if ($this->viewData["id"] > 0) {
                $tmpCategoria = CategoriesDAO::getCategoriesById(
                    $this->viewData["id"]
                );
                if (count($tmpCategoria) > 0) {
                    $this->viewData["categoria"] = $tmpCategoria["categoria"];
                    $this->viewData["estado"] = $tmpCategoria["estado"];
                }
            }
        }
        Renderer::render("maintenance/products/category", $this->viewData);
    }
}
