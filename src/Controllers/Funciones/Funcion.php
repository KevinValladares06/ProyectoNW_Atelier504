<?php

namespace Controllers\Funciones;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Funciones\Funciones as FuncionesDao;
use Utilities\Site;
use Utilities\Validators;

class Funcion extends PublicController
{
    private $viewData = [];
    private $mode = "DSP";
    private $modeDescriptions = [
        "DSP" => "Detalle de %s",
        "INS" => "Nueva Función",
        "UPD" => "Editar %s",
        "DEL" => "Eliminar %s"
    ];
    private $readonly = "";
    private $showCommitBtn = true;
    private $funcion = [
        "fncod" => "",
        "fndsc" => "",
        "fnest" => "",
        "fntyp" => ""
    ];
    private $funcion_xss_token = "";

    public function run(): void
    {
        try {
            $this->getData();
            if ($this->isPostBack()) {
                if ($this->validateData()) {
                    $this->handlePostAction();
                }
            }
            $this->setViewData();
            Renderer::render("funciones/funcion", $this->viewData);
        } catch (\Exception $ex) {
            Site::redirectToWithMsg(
                "index.php?page=Funciones_Funciones",
                $ex->getMessage()
            );
        }
    }

    private function getData()
    {
        $this->mode = $_GET["mode"] ?? "NOF";
        if (isset($this->modeDescriptions[$this->mode])) {
            $this->readonly = $this->mode === "DEL" ? "readonly" : "";
            $this->showCommitBtn = $this->mode !== "DSP";

            if ($this->mode !== "INS") {
                $id = $_GET["id"] ?? $_GET["fncod"] ?? "";
                $this->funcion = FuncionesDao::getById($id);
                if (!$this->funcion) {
                    throw new \Exception("No se encontró la funcion", 1);
                }
            }
        } else {
            throw new \Exception("Modo inválido", 1);
        }
    }

    private function validateData(): bool
    {
        $errors = [];
        $this->funcion_xss_token = $_POST["funcion_xss_token"] ?? "";
        $this->funcion["fncod"] = strval($_POST["fncod"] ?? "");

        if ($this->mode !== "DEL") {
            $this->funcion["fndsc"] = strval($_POST["fndsc"] ?? "");
            $this->funcion["fnest"] = strval($_POST["fnest"] ?? "");
            $this->funcion["fntyp"] = strval($_POST["fntyp"] ?? "");

            if (Validators::IsEmpty($this->funcion["fncod"])) {
                $errors["fncod_error"] = "El código de la funcion es requerido";
            }
            if (Validators::IsEmpty($this->funcion["fndsc"])) {
                $errors["fndsc_error"] = "La descripción es requerida";
            }
            if (Validators::IsEmpty($this->funcion["fnest"])) {
                $errors["fnest_error"] = "El estado es requerido";
            }
            if (Validators::IsEmpty($this->funcion["fntyp"])) {
                $errors["fntyp_error"] = "El tipo es requerido";
            }
        }

        if (count($errors) > 0) {
            foreach ($errors as $key => $msg) {
                $this->funcion[$key] = $msg;
            }
            return false;
        }
        return true;
    }

    private function handlePostAction(): void
    {
        switch ($this->mode) {
            case "INS":
                $this->handleInsert();
                break;
            case "UPD":
                $this->handleUpdate();
                break;
            case "DEL":
                $this->handleDelete();
                break;
            default:
                throw new \Exception("Acción no válida");
        }
    }

    private function handleInsert(): void
    {
        $result = FuncionesDao::insertFunciones(
            $this->funcion["fncod"],
            $this->funcion["fndsc"],
            $this->funcion["fnest"],
            $this->funcion["fntyp"],
        );
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Funciones_Funciones",
                "Funcion creada exitosamente"
            );
        }
    }

    private function handleUpdate(): void
    {
        $result = FuncionesDao::updateFunciones(
            $this->funcion["fncod"],
            $this->funcion["fndsc"],
            $this->funcion["fnest"],
            $this->funcion["fntyp"],
        );
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Funciones_Funciones",
                "Funcion actualizada correctamente"
            );
        }
    }

    private function handleDelete(): void
    {
        $result = FuncionesDao::deleteFunciones($this->funcion["fncod"]);
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Funciones_Funciones",
                "Funcion eliminada correctamente"
            );
        }
    }

    private function setViewData(): void
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["funcion_xss_token"] = $this->funcion_xss_token;
        $this->viewData["FormTitle"] = sprintf(
            $this->modeDescriptions[$this->mode],
            $this->funcion["fncod"]
        );
        $this->viewData["readonly"] = $this->readonly;
        $this->viewData["showCommitBtn"] = $this->showCommitBtn;
        $this->viewData["funcion"] = $this->funcion;
    }
}
