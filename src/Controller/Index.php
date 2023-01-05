<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Index extends AbstractController
{
    #[Route("/", name: "index")]
    public function index()
    {
        return $this->render('base.html.twig');
    }

    #[Route("/datatable", name: "datatable")]
    public function datatable()
    {
        return $this->render('datatables/scrollable.html.twig');
    }
}
