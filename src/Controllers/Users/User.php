<?php

namespace Controllers\Users;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Users\Users as UsersDao;
use Utilities\Site;
use Utilities\Validators;

class User extends PublicController
{
    private $viewData = [];
    private $mode = "DSP";
    private $modeDescriptions = [
        "DSP" => "Detalle de %s %s",
        "INS" => "Nuevo Usuario",
        "UPD" => "Editar %s %s",
        "DEL" => "Eliminar %s %s"
    ];
    private $readonly = "";
    private $showCommitBtn = true;
    private $user = [
        "usercod" => 0,
        "useremail" => "",
        "username" => "",
        "userpass" => "",
        "userfching" => "",
        "userpswdest" => "ACT",
        "userpswdexp" => "",
        "userest" => "ACT",
        "useractcod" => "",
        "userpswdchg" => "",
        "usertipo" => "NOR"
    ];
    private $user_xss_token = "";

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
            Renderer::render("users/user", $this->viewData);
        } catch (\Exception $ex) {
            Site::redirectToWithMsg(
                "index.php?page=Users_Users",
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
                $this->user = UsersDao::getUserById(intval($_GET["usercod"] ?? $_GET["id"] ?? 0));
                if (!$this->user) {
                    throw new \Exception("No se encontró el Usuario", 1);
                }
            }
        } else {
            throw new \Exception("Formulario cargado en modalidad invalida", 1);
        }
    }

    private function validateData()
    {
        $errors = [];
        $this->user_xss_token = $_POST["user_xss_token"] ?? "";
        $this->user["usercod"] = intval($_POST["usercod"] ?? "");

        if ($this->mode !== "DEL") {
            $this->user["username"] = strval($_POST["username"] ?? "");
            $this->user["useremail"] = strval($_POST["useremail"] ?? "");
            $this->user["userpass"] = strval($_POST["userpass"] ?? "");
            $this->user["userest"] = strval($_POST["userest"] ?? "");
            $this->user["userfching"] = $_POST["userfching"] ?? date('Y-m-d\TH:i');
            $this->user["userpswdest"] = $_POST["userpswdest"] ?? "ACT";
            $this->user["userpswdexp"] = $_POST["userpswdexp"] ?? date('Y-m-d\TH:i', strtotime('+90 days'));
            $this->user["useractcod"] = $_POST["useractcod"] ?? "";
            $this->user["userpswdchg"] = $_POST["userpswdchg"] ?? "";
            $this->user["usertipo"] = $_POST["usertipo"] ?? "NOR";

            if (Validators::IsEmpty($this->user["username"])) {
                $errors["username_error"] = "El nombre de usuario es requerido";
            }

            if (Validators::IsEmpty($this->user["useremail"])) {
                $errors["useremail_error"] = "El email es requerido";
            } elseif (!filter_var($this->user["useremail"], FILTER_VALIDATE_EMAIL)) {
                $errors["useremail_error"] = "El email no es válido";
            }

            if ($this->mode === "INS" || ($this->mode === "UPD" && !empty($this->user["userpass"]))) {
                if (Validators::IsEmpty($this->user["userpass"])) {
                    $errors["userpass_error"] = "La contraseña es requerida";
                }
            }

            if (Validators::IsEmpty($this->user["userest"], ["ACT", "INA"])) {
                $errors["userest_error"] = "El estado del usuario es inválido";
            }
        }

        if (count($errors) > 0) {
            foreach ($errors as $key => $value) {
                $this->user[$key] = $value;
            }
            return false;
        }
        return true;
    }

    private function handlePostAction()
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
                throw new \Exception("Modo Invalido", 1);
        }
    }

    private function handleInsert()
    {

        $hashedPassword = password_hash($this->user["userpass"], PASSWORD_DEFAULT);

        $result = UsersDao::insertUser(
            $this->user["useremail"],
            $this->user["username"],
            $hashedPassword,
            $this->user["userfching"],
            $this->user["userpswdest"],
            $this->user["userpswdexp"],
            $this->user["userest"],
            $this->user["useractcod"],
            $this->user["userpswdchg"],
            $this->user["usertipo"]
        );
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Users_Users",
                "Usuario creado exitosamente"
            );
        }
    }


    private function handleUpdate()
    {

        if (!empty($this->user["userpass"])) {
            $hashedPassword = password_hash($this->user["userpass"], PASSWORD_DEFAULT);
        } else {

            $existingUser = UsersDao::getUserById($this->user["usercod"]);
            $hashedPassword = $existingUser["userpass"] ?? "";
        }

        $result = UsersDao::updateUser(
            $this->user["usercod"],
            $this->user["useremail"],
            $this->user["username"],
            $hashedPassword,
            $this->user["userfching"],
            $this->user["userpswdest"],
            $this->user["userpswdexp"],
            $this->user["userest"],
            $this->user["useractcod"],
            $this->user["userpswdchg"],
            $this->user["usertipo"]
        );
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Users_Users",
                "Usuario actualizado exitosamente"
            );
        }
    }

    private function handleDelete()
    {
        $result = UsersDao::deleteUser($this->user["usercod"]);
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Users_Users",
                "Usuario eliminado exitosamente"
            );
        }
    }

    private function setViewData(): void
    {

        $this->viewData["mode"] = $this->mode;
        $this->viewData["user_xss_token"] = $this->user_xss_token;


        $this->viewData["FormTitle"] = sprintf(
            $this->modeDescriptions[$this->mode],
            $this->user["usercod"] ?? '',
            $this->user["username"] ?? ''
        );


        $this->viewData["showCommitBtn"] = $this->showCommitBtn;


        $this->viewData["readonly"] = $this->readonly;


        if (isset($this->user["userest"])) {
            $userStatusKey = "userest_" . strtolower($this->user["userest"]);
            $this->user[$userStatusKey] = "selected";
        }


        if (isset($this->user["userpswdest"])) {
            $pswdStatusKey = "userpswdest_" . strtolower($this->user["userpswdest"]);
            $this->user[$pswdStatusKey] = "selected";
        }

        if (isset($this->user["usertipo"])) {
            $tipoKey = "usertipo_" . strtolower($this->user["usertipo"]);
            $this->user[$tipoKey] = "selected";
        }
        $this->viewData["user"] = $this->user;
    }
}
