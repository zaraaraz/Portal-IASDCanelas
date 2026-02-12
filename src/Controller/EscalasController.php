<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/escalas')]
final class EscalasController extends AbstractController
{
    #[Route('', name: 'escalas_index')]
    public function index(): Response
    {
        return $this->render('portal/escalas.html.twig');
    }
}
