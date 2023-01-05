<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/calendario')]
class CalendarioController extends AbstractController
{
    #[Route("/show", name: "calendario_show")]
    public function show()
    {
        return $this->render('calendario/calendario.html.twig');
    }
}
