<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/documentos')]
final class DocumentosController extends AbstractController
{
    #[Route('', name: 'documentos_index')]
    public function index(): Response
    {
        return $this->render('portal/documentos.html.twig');
    }
}
