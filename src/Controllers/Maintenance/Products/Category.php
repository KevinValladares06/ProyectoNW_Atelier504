<?php

namespace Controllers\Maintenance\Products;

use Controllers\PublicController;
use Dao\Products\Categories as CategoriesDAO;
use Views\Renderer;

use Utilities\Site;
use Utilities\Validators;

const LIST_URL = "index.php?page=Maintenance-Products-Categories";

class Category extends PublicController
{
    private array $viewData;
    private array $modes;
    private array $status;
    public function __construct()
    {
        $this->viewData = [
            "mode" => "",
            "id" => 0,
            "categoria" => "",
            "estado" => "ACT",
            "modeDsc" => "",
            "selectedACT" => "",
            "selectedINA" => "",
            "selectedRTR" => "",
            "errors" => [],
            "cancelLabel" => "Cancel",
            "showConfirm" => true,
            "readonly" => ""
        ];
        $this->modes = [
            "INS" => "New Category",
            "UPD" => "Updating %s",
            "DEL" => "Deleting %s",
            "DSP" => "Details of %s"
        ];

        $this->status = ["ACT", "INA", "RTR"];
    }
    public function run(): void
    {

        /*
        1 - Cargar la data de query params
        2 - Determinamos el MODO de ejecución del Formulario
        3 - Si el MODO no es INS
            3.1 - Cargar los datos de la DB
        4 - Si la solicitud Postback  (POST | PUT | DELETE)
            4.1 - Cargar los datos del Body ( POST )
            4.2 - Validar los datos
            4.3 - Ejecutar el métodos según el MODO
            4.4 - Mostrar mensaje y enviar a Listados
        5 - Prepara la data para la vista
        6 - Renderizar la Vista
        */
        $this->getQueryParamsData();
        if ($this->viewData["mode"] !== "INS") {
            $this->getDataFromDB();
        }
        if ($this->isPostBack()) {
            $this->getBodyData();
            if ($this->validateData()) {
                $this->processData();
            }
        }
        $this->prepareViewData();
        Renderer::render("maintenance/products/category", $this->viewData);
    }

    private function throwError(string $message, string $logMessage = "")
    {
        if (!empty($logMessage)) {
            error_log(sprintf("%s - %s", $this->name, $this->$logMessage));
        }
        Site::redirectToWithMsg(LIST_URL, $message);
    }
    private function innerError(string $scope, string $message)
    {
        if (!isset($this->viewData["errors"][$scope])) {
            $this->viewData["errors"][$scope] = [$message];
        } else {
            $this->viewData["errors"][$scope][] = $message;
        }
    }

    private function getQueryParamsData()
    {
        if (!isset($_GET["mode"])) {
            $this->throwError(
                "Something went wrong, try again.",
                "Attempt to load controler without the required query parameters MODE"
            );
        }
        $this->viewData["mode"] = $_GET["mode"];
        if (!isset($this->modes[$this->viewData["mode"]])) {
            $this->throwError(
                "Something went wrong, try again.",
                "Attempt to load controler with  wrong value on query parameter MODE - " . $this->viewData["mode"]
            );
        }
        if ($this->viewData["mode"] !== "INS") {
            if (!isset($_GET["id"])) {
                $this->throwError(
                    "Something went wrong, try again.",
                    "Attempt to load controler without the required query parameters ID"
                );
            }
            if (!is_numeric($_GET["id"])) {
                $this->throwError(
                    "Something went wrong, try again.",
                    "Attempt to load controler with  wrong value on query parameter ID - " . $_GET["id"]
                );
            }
            $this->viewData["id"] = intval($_GET["id"]);
        }
    }

    private function getDataFromDB()
    {
        $tmpCategoria = CategoriesDAO::getCategoriesById(
            $this->viewData["id"]
        );
        if ($tmpCategoria && count($tmpCategoria) > 0) {
            $this->viewData["categoria"] = $tmpCategoria["categoria"];
            $this->viewData["estado"] = $tmpCategoria["estado"];
        } else {
            $this->throwError(
                "Something went wrong, try again.",
                "Record for id " . $this->viewData["id"] . " not found."
            );
        }
    }

    private function getBodyData()
    {
        if (!isset($_POST["id"])) {
            $this->throwError(
                "Something went wrong, try again.",
                "Trying to post without parameter ID on body"
            );
        }
        if (!isset($_POST["categoria"])) {
            $this->throwError(
                "Something went wrong, try again.",
                "Trying to post without parameter CATEGORY on body"
            );
        }
        if (!isset($_POST["estado"])) {
            $this->throwError(
                "Something went wrong, try again.",
                "Trying to post without parameter ESTADO on body"
            );
        }
        if (!isset($_POST["xsrtoken"])) {
            $this->throwError(
                "Something went wrong, try again.",
                "Trying to post without parameter XSRTOKEN on body"
            );
        }
        if (intval($_POST["id"]) !== $this->viewData["id"]) {
            $this->throwError(
                "Something went wrong, try again.",
                "Trying to post with inconsistent parameter ID value has: " . $this->viewData["id"] . " recieved: " . $_POST["id"]
            );
        }
        if ($_POST["xsrtoken"] !==  $_SESSION[$this->name . "-xsrtoken"]) {
            $this->throwError(
                "Something went wrong, try again.",
                "Trying to post with inconsistent parameter XSRToken value has: " . $_SESSION[$this->name . "-xsrtoken"] . " recieved: " . $_POST["xsrtoken"]
            );
        }

        $this->viewData["categoria"] = $_POST["categoria"];
        $this->viewData["estado"] = $_POST["estado"];
    }

    private function validateData(): bool
    {
        if (Validators::IsEmpty($this->viewData["categoria"])) {
            $this->innerError("categoria", "This field is required.");
        }
        if (strlen($this->viewData["categoria"]) > 255) {
            $this->innerError("categoria", "Value is too long. Maximun allowed 255 character.");
        }
        if (!in_array($this->viewData["estado"], $this->status)) {
            $this->innerError("estado", "This field is required.");
        }

        return !(count($this->viewData["errors"]) > 0);
    }

    private function processData()
    {
        $mode = $this->viewData["mode"];
        switch ($mode) {
            case "INS":
                if (CategoriesDAO::newCategory(
                    $this->viewData["categoria"],
                    $this->viewData["estado"]
                ) > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Category created successfuly");
                } else {
                    $this->innerError("global", "Something wrong happend to save the new Category.");
                }
                break;
            case "UPD":
                if (CategoriesDAO::updateCategory(
                    $this->viewData["id"],
                    $this->viewData["categoria"],
                    $this->viewData["estado"]
                ) > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Category updated successfuly");
                } else {
                    $this->innerError("global", "Something wrong happend while updating the category.");
                }
                break;
            case "DEL":
                if (CategoriesDAO::deleteCategory(
                    $this->viewData["id"]
                ) > 0) {
                    Site::redirectToWithMsg(LIST_URL, "Category deleted successfuly");
                } else {
                    $this->innerError("global", "Something wrong happend while deleting the category.");
                }
                break;
        }
    }
    private function prepareViewData()
    {
        $this->viewData["modeDsc"] = sprintf(
            $this->modes[$this->viewData["mode"]],
            $this->viewData["categoria"]
        );

        $this->viewData['selected' . $this->viewData["estado"]] = "selected";

        if (count($this->viewData["errors"]) > 0) {
            foreach ($this->viewData["errors"] as $scope => $errorsArray) {
                $this->viewData["errors_" . $scope] = $errorsArray;
            }
        }

        if ($this->viewData["mode"] === "DSP") {
            $this->viewData["cancelLabel"] = "Back";
            $this->viewData["showConfirm"] = false;
        }

        if ($this->viewData["mode"] === "DSP" || $this->viewData["mode"] === "DEL") {
            $this->viewData["readonly"] = "readonly";
        }
        $this->viewData["timestamp"] = time();
        $this->viewData["xsrtoken"] = hash("sha256", json_encode($this->viewData));
        $_SESSION[$this->name . "-xsrtoken"] = $this->viewData["xsrtoken"];
    }
}
