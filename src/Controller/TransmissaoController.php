<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/transmissao')]
final class TransmissaoController extends AbstractController
{
    #[Route('', name: 'transmissao_index')]
    public function index(): Response
    {
        return $this->render('portal/transmissao.html.twig');
    }
}
