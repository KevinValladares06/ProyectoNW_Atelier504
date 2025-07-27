<?php

namespace Controllers\Roles;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Roles\Roles as RolesDao;
use Utilities\Site;
use Utilities\Validators;

class Rol extends PublicController
{
    private $viewData = [];
    private $mode = "DSP";
    private $modeDescriptions = [
        "DSP" => "Detalle de %s",
        "INS" => "Nuevo Rol",
        "UPD" => "Editar %s",
        "DEL" => "Eliminar %s"
    ];
    private $readonly = "";
    private $showCommitBtn = true;
    private $rol = [
        "rolescod" => "",
        "rolesdsc" => "",
        "rolesest" => ""
    ];
    private $rol_xss_token = "";

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
            Renderer::render("roles/rol", $this->viewData);
        } catch (\Exception $ex) {
            Site::redirectToWithMsg(
                "index.php?page=Roles_Roles",
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
                $id = $_GET["id"] ?? $_GET["rolescod"] ?? "";
                $this->rol = RolesDao::getById($id);
                if (!$this->rol) {
                    throw new \Exception("No se encontró el rol", 1);
                }
            }
        } else {
            throw new \Exception("Modo inválido", 1);
        }
    }

    private function validateData(): bool
    {
        $errors = [];
        $this->rol_xss_token = $_POST["rol_xss_token"] ?? "";
        $this->rol["rolescod"] = strval($_POST["rolescod"] ?? "");

        if ($this->mode !== "DEL") {
            $this->rol["rolesdsc"] = strval($_POST["rolesdsc"] ?? "");
            $this->rol["rolesest"] = strval($_POST["rolesest"] ?? "");

            if (Validators::IsEmpty($this->rol["rolescod"])) {
                $errors["rolescod_error"] = "El código del rol es requerido";
            }
            if (Validators::IsEmpty($this->rol["rolesdsc"])) {
                $errors["rolesdsc_error"] = "La descripción es requerida";
            }
            if (Validators::IsEmpty($this->rol["rolesest"])) {
                $errors["rolesest_error"] = "El estado es requerido";
            }
        }

        if (count($errors) > 0) {
            foreach ($errors as $key => $msg) {
                $this->rol[$key] = $msg;
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
        $result = RolesDao::insertRoles(
            $this->rol["rolescod"],
            $this->rol["rolesdsc"],
            $this->rol["rolesest"]
        );
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Roles_Roles",
                "Rol creado exitosamente"
            );
        }
    }

    private function handleUpdate(): void
    {
        $result = RolesDao::updateRoles(
            $this->rol["rolescod"],
            $this->rol["rolesdsc"],
            $this->rol["rolesest"]
        );
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Roles_Roles",
                "Rol actualizado correctamente"
            );
        }
    }

    private function handleDelete(): void
    {
        $result = RolesDao::deleteRoles($this->rol["rolescod"]);
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Roles_Roles",
                "Rol eliminado correctamente"
            );
        }
    }

    private function setViewData(): void
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["rol_xss_token"] = $this->rol_xss_token;
        $this->viewData["FormTitle"] = sprintf(
            $this->modeDescriptions[$this->mode],
            $this->rol["rolescod"]
        );
        $this->viewData["readonly"] = $this->readonly;
        $this->viewData["showCommitBtn"] = $this->showCommitBtn;
        $this->viewData["rol"] = $this->rol;
    }
}
