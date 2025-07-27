<?php

namespace Controllers\Students;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Students\Students as StudentsDao;
use Utilities\Site;
use Utilities\Validators;

class Student extends PublicController
{
    private $viewData = [];
    private $mode = "DSP";
    private $modeDescriptions = [
        "DSP" => "Detalle del estudiante %s %s",
        "INS" => "Nuevo Estudiante",
        "UPD" => "Editar estudiante %s %s",
        "DEL" => "Eliminar estudiante %s %s"
    ];
    private $readonly = "";
    private $showCommitBtn = true;
    private $student = [
        "id_estudiante" => 0,
        "nombre" => "",
        "apellido" => "",
        "edad" => 0,
        "especialidad" => ""
    ];
    private $student_xss_token = "";

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
            Renderer::render("students/student", $this->viewData);
        } catch (\Exception $ex) {
            Site::redirectToWithMsg(
                "index.php?page=Students_Students",
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
                $this->student = StudentsDao::getStudentById(intval($_GET["id_estudiante"] ?? $_GET["id"] ?? 0));
                if (!$this->student) {
                    throw new \Exception("No se encontró el Estudiante", 1);
                }
            }
        } else {
            throw new \Exception("Formulario cargado en modalidad inválida", 1);
        }
    }

    private function validateData()
    {
        $errors = [];
        $this->student_xss_token = $_POST["student_xss_token"] ?? "";
        $this->student["id_estudiante"] = intval($_POST["id_estudiante"] ?? "");

        if ($this->mode !== "DEL") {
            $this->student["nombre"] = strval($_POST["nombre"] ?? "");
            $this->student["apellido"] = strval($_POST["apellido"] ?? "");
            $this->student["edad"] = intval($_POST["edad"] ?? 0);
            $this->student["especialidad"] = strval($_POST["especialidad"] ?? "");

            if (Validators::IsEmpty($this->student["nombre"])) {
                $errors["nombre_error"] = "El nombre es requerido";
            }

            if (Validators::IsEmpty($this->student["apellido"])) {
                $errors["apellido_error"] = "El apellido es requerido";
            }

            if ($this->student["edad"] <= 0) {
                $errors["edad_error"] = "La edad debe ser un número mayor a cero";
            }

            if (Validators::IsEmpty($this->student["especialidad"])) {
                $errors["especialidad_error"] = "La especialidad es requerida";
            }
        }

        if (count($errors) > 0) {
            foreach ($errors as $key => $value) {
                $this->student[$key] = $value;
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
                throw new \Exception("Modo inválido", 1);
                break;
        }
    }

    private function handleInsert()
    {
        $result = StudentsDao::insertStudent(
            $this->student["nombre"],
            $this->student["apellido"],
            $this->student["edad"],
            $this->student["especialidad"]
        );
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Students_Students",
                "Estudiante creado exitosamente"
            );
        }
    }

    private function handleUpdate()
    {
        $result = StudentsDao::updateStudent(
            $this->student["id_estudiante"],
            $this->student["nombre"],
            $this->student["apellido"],
            $this->student["edad"],
            $this->student["especialidad"]
        );
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Students_Students",
                "Estudiante actualizado exitosamente"
            );
        }
    }

    private function handleDelete()
    {
        $result = StudentsDao::deleteStudent($this->student["id_estudiante"]);
        if ($result > 0) {
            Site::redirectToWithMsg(
                "index.php?page=Students_Students",
                "Estudiante eliminado exitosamente"
            );
        }
    }

    private function setViewData(): void
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["student_xss_token"] = $this->student_xss_token;
        $this->viewData["FormTitle"] = sprintf(
            $this->modeDescriptions[$this->mode],
            $this->student["nombre"],
            $this->student["apellido"]
        );
        $this->viewData["showCommitBtn"] = $this->showCommitBtn;
        $this->viewData["readonly"] = $this->readonly;

        $this->viewData["student"] = $this->student;
    }
}
