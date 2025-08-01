<?php

namespace Controllers;

class AcercaDeNosotros extends PublicController
{
    public function run(): void
    {
        $viewData = array();
        $viewData["page_title"] = "Acerca de Nosotros";
        \Views\Renderer::render('acercadenosotros', $viewData);
    }
}