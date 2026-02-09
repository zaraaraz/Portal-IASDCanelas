<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('portal/dashboard.html.twig');
    }

    #[Route('/dashboard', name: 'dashboard_index')]
    public function index(): Response
    {
        return $this->render('portal/dashboard.html.twig');
    }
}
