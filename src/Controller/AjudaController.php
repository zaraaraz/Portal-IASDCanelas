<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ajuda')]
final class AjudaController extends AbstractController
{
    #[Route('', name: 'ajuda_index')]
    public function index(): Response
    {
        return $this->render('portal/ajuda.html.twig');
    }
}
