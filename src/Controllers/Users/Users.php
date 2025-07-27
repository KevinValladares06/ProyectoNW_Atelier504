<?php

namespace Controllers\Users;

use Controllers\PublicController;
use Utilities\Context;
use Utilities\Paging;
use Dao\Users\Users as DaoUsers;
use Views\Renderer;

class Users extends PublicController
{
    private $partialName = "";
    private $status = "";
    private $orderBy = "";
    private $orderDescending = false;
    private $pageNumber = 1;
    private $itemsPerPage = 10;
    private $viewData = [];
    private $users = [];
    private $usersCount = 0;
    private $pages = 0;

    public function run(): void
    {
        $this->getParamsFromContext();
        $this->getParams();

        $tmpUsers = DaoUsers::getUsers(
            $this->partialName,
            $this->status,
            $this->orderBy,
            $this->orderDescending,
            $this->pageNumber - 1,
            $this->itemsPerPage
        );

        //var_dump($tmpUsers);
        //exit();

        $this->users = $tmpUsers["users"];
        $this->usersCount = $tmpUsers["total"];
        $this->pages = $this->usersCount > 0 ? ceil($this->usersCount / $this->itemsPerPage) : 1;

        if ($this->pageNumber > $this->pages) {
            $this->pageNumber = $this->pages;
        }

        $this->setParamsToContext();
        $this->setParamsToDataView();
        Renderer::render("users/users", $this->viewData);
    }

    private function getParams(): void
    {
        $this->partialName = isset($_GET["partialName"]) ? $_GET["partialName"] : $this->partialName;
        $this->status = isset($_GET["status"]) && in_array($_GET["status"], ['ACT', 'INA', 'EMP']) ? $_GET["status"] : $this->status;
        if ($this->status === "EMP") {
            $this->status = "";
        }
        $this->orderBy = isset($_GET["orderBy"]) && in_array($_GET["orderBy"], ["usercod", "username", "useremail", "clear"]) ? $_GET["orderBy"] : $this->orderBy;
        if ($this->orderBy === "clear") {
            $this->orderBy = "";
        }
        $this->orderDescending = isset($_GET["orderDescending"]) ? boolval($_GET["orderDescending"]) : $this->orderDescending;
        $this->pageNumber = isset($_GET["pageNum"]) ? intval($_GET["pageNum"]) : $this->pageNumber;
        $this->itemsPerPage = isset($_GET["itemsPerPage"]) ? intval($_GET["itemsPerPage"]) : $this->itemsPerPage;
    }

    private function getParamsFromContext(): void
    {
        $this->partialName = Context::getContextByKey("users_partialName");
        $this->status = Context::getContextByKey("users_status");
        $this->orderBy = Context::getContextByKey("users_orderBy");
        $this->orderDescending = boolval(Context::getContextByKey("users_orderDescending"));
        $this->pageNumber = intval(Context::getContextByKey("users_page"));
        $this->itemsPerPage = intval(Context::getContextByKey("users_itemsPerPage"));
        if ($this->pageNumber < 1) $this->pageNumber = 1;
        if ($this->itemsPerPage < 1) $this->itemsPerPage = 10;
    }

    private function setParamsToContext(): void
    {
        Context::setContext("users_partialName", $this->partialName, true);
        Context::setContext("users_status", $this->status, true);
        Context::setContext("users_orderBy", $this->orderBy, true);
        Context::setContext("users_orderDescending", $this->orderDescending, true);
        Context::setContext("users_page", $this->pageNumber, true);
        Context::setContext("users_itemsPerPage", $this->itemsPerPage, true);
    }

    private function setParamsToDataView(): void
    {
        $this->viewData["partialName"] = $this->partialName;
        $this->viewData["status"] = $this->status;
        $this->viewData["orderBy"] = $this->orderBy;
        $this->viewData["orderDescending"] = $this->orderDescending;
        $this->viewData["pageNum"] = $this->pageNumber;
        $this->viewData["itemsPerPage"] = $this->itemsPerPage;
        $this->viewData["usersCount"] = $this->usersCount;
        $this->viewData["pages"] = $this->pages;
        $this->viewData["users"] = $this->users;

        if ($this->orderBy !== "") {
            $orderByKey = "Order" . ucfirst($this->orderBy);
            $orderByKeyNoOrder = "OrderBy" . ucfirst($this->orderBy);
            $this->viewData[$orderByKeyNoOrder] = true;
            if ($this->orderDescending) {
                $orderByKey .= "Desc";
            }
            $this->viewData[$orderByKey] = true;
        }

        $statusKey = "status_" . ($this->status === "" ? "EMP" : $this->status);
        $this->viewData[$statusKey] = "selected";

        $pagination = Paging::getPagination(
            $this->usersCount,
            $this->itemsPerPage,
            $this->pageNumber,
            "index.php?page=Users_Users",
            "Users_Users"
        );
        $this->viewData["pagination"] = $pagination;
    }
}
