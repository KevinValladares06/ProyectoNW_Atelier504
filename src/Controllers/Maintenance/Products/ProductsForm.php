<?php

namespace Controllers\Mantenimientos\Productos;

use Dao\Mantenimientos\Productos\Products as ProductsDao;
use Controllers\PublicController;
use Views\Renderer;
use Utilities\Site;

class ProductsForm extends PublicController
{
    private $viewData = [];
    private $mode = "DSP";
    private $modeDsc = [
        "DSP" => "View Products",
        "INS" => "Add Products",
        "UPD" => "Update Products",
        "DEL" => "Delete Products"
    ];

    private $isReadOnly = "readonly";
    private $hasErrors = false;
    private $errors = [];
    private $crf_token = "";

    private $productId = 0;
    private $productName = "";
    private $productDescription = "";
    private $productPrice = 0;
    private $productImgUrl = "";
    private $productStock = 0;
    private $productStatus = "";

    private function throwError($message, $scope = "global")
    {
        $this->hasErrors = true;
        error_log($message);
        if (!isset($this->errors[$scope])) {
            $this->errors[$scope] = [];
        }
        $this->errors[$scope][] = $message;
    }

    private function cargarDatos()
    {
        $this->productId = isset($_GET["productId"]) ? intval($_GET["productId"]) : 0;
        $this->mode = isset($_GET["mode"]) ? $_GET["mode"] : "DSP";

        if (
            $this->productId > 0
        ) {
            $products = ProductsDao::getByPrimaryKey($this->productId);
            if ($products) {
                $this->productId = $products["productId"];
                $this->productName = $products["productName"];
                $this->productDescription = $products["productDescription"];
                $this->productPrice = $products["productPrice"];
                $this->productImgUrl = $products["productImgUrl"];
                $this->productStock = $products["productStock"];
                $this->productStatus = $products["productStatus"];
            }
        }
    }

    private function getPostData()
    {
        $tmp_productName = isset($_POST["productName"]) ? strval($_POST["productName"]) : "";
        $tmp_productDescription = isset($_POST["productDescription"]) ? strval($_POST["productDescription"]) : "";
        $tmp_productPrice = isset($_POST["productPrice"]) ? floatval($_POST["productPrice"]) : 0;
        $tmp_productImgUrl = isset($_POST["productImgUrl"]) ? strval($_POST["productImgUrl"]) : "";
        $tmp_productStock = isset($_POST["productStock"]) ? intval($_POST["productStock"]) : 0;
        $tmp_productStatus = isset($_POST["productStatus"]) ? strval($_POST["productStatus"]) : "";
        $tmp_mode = isset($_POST["mode"]) ? $_POST["mode"] : "DSP";
        $tmp_crf_token = isset($_POST["crf_token"]) ? $_POST["crf_token"] : "";
        // Do Fields Validation

        if ($this->mode !== $tmp_mode) {
            $this->throwError("Modo de formulario inválido");
        }
        if (!$this->validateCsfrToken()) {
            $this->throwError("Error de aplicación, Token CSRF Inválido");
        }
        $this->productName = $tmp_productName;
        $this->productDescription = $tmp_productDescription;
        $this->productPrice = $tmp_productPrice;
        $this->productImgUrl = $tmp_productImgUrl;
        $this->productStock = $tmp_productStock;
        $this->productStatus = $tmp_productStatus;
        $this->mode = $tmp_mode;
    }

    private function validateCsfrToken()
    {
        if ($this->crf_token !== $_SESSION["crf_token"]) {
            $this->throwError("Error de aplicación, Token CSRF Inválido");
            return false;
        }
        return true;
    }

    private function csfrToken()
    {
        $this->crf_token = md5(uniqid(rand(), true));
        $_SESSION["crf_token"] = $this->crf_token;
    }

    private function processAction()
    {
        switch ($this->mode) {
            case "INS":
                $inserted = ProductsDao::add(
                    $this->productName,
                    $this->productDescription,
                    $this->productPrice,
                    $this->productImgUrl,
                    $this->productStock,
                    $this->productStatus
                );
                if ($inserted) {
                    Site::redirectToWithMsg(
                        "index.php?page=Mantenimientos\Productos_ProductsList",
                        "Registro Agregado Exitosamente"
                    );
                } else {
                    $this->throwError("Error al agregar el registro");
                }
                break;
            case "UPD":
                $updated = ProductsDao::update(
                    $this->productId,
                    $this->productName,
                    $this->productDescription,
                    $this->productPrice,
                    $this->productImgUrl,
                    $this->productStock,
                    $this->productStatus,
                );
                if ($updated) {
                    Site::redirectToWithMsg(
                        "index.php?page=Mantenimientos_Productos_ProductsList",
                        "Registro Actualizado Exitosamente"
                    );
                } else {
                    $this->throwError("Error al actualizar el registro");
                }
                break;
            case "DEL":
                $deleted = ProductsDao::delete($this->productId);
                if ($deleted) {
                    Site::redirectToWithMsg(
                        "index.php?page=Mantenimientos_Productos_ProductsList",
                        "Registro Eliminado Exitosamente"
                    );
                } else {
                    $this->throwError("Error al eliminar el registro");
                }
                break;
        }
    }

    private function prepareViewData()
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["modeDesc"] = sprintf($this->modeDsc[$this->mode], $this->productId);
        $this->viewData["productId"] = $this->productId;
        $this->viewData["productName"] = $this->productName;
        $this->viewData["productDescription"] = $this->productDescription;
        $this->viewData["productPrice"] = $this->productPrice;
        $this->viewData["productImgUrl"] = $this->productImgUrl;
        $this->viewData["productStock"] = $this->productStock;
        $this->viewData["productStatus"] = $this->productStatus;
        if ($this->mode === "INS" || $this->mode === "UPD") {
            $this->isReadOnly = "";
        }
        $this->viewData["isReadOnly"] = $this->isReadOnly;
        $this->viewData["showAction"] = $this->mode !== "DSP";
        $this->csfrToken();
        $this->viewData["crf_token"] = $this->crf_token;
        $this->viewData["hasErrors"] = $this->hasErrors;
        $this->viewData["errors"] = $this->errors;
    }

    public function run(): void
    {
        $this->cargarDatos();
        if ($this->isPostBack()) {
            $this->getPostData();
            if (!$this->hasErrors) {
                $this->processAction();
            }
        }
        $this->prepareViewData();
        Renderer::render("mantenimientos/productos/products_form", $this->viewData);
    }
}
