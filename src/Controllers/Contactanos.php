<?php

namespace Controllers;

class Contactanos extends PublicController
{
    public function run(): void
    {
        $viewData = array();
        $viewData["page_title"] = "Contáctanos";
        \Views\Renderer::render('contactanos', $viewData);
    }
}