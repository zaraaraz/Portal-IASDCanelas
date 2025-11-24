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
        return $this->render('dashboard/index.html.twig');
    }

    #[Route('/dashboard', name: 'dashboard_index')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig');
    }

    #[Route('/dashboard/analytics', name: 'dashboard_analytics')]
    public function analytics(): Response
    {
        return $this->render('dashboard/analytics.html.twig');
    }

    #[Route('/dashboard/ecommerce', name: 'dashboard_ecommerce')]
    public function ecommerce(): Response
    {
        return $this->render('dashboard/ecommerce.html.twig');
    }

    #[Route('/dashboard/crm', name: 'dashboard_crm')]
    public function crm(): Response
    {
        return $this->render('dashboard/crm.html.twig');
    }

    #[Route('/dashboard/finance', name: 'dashboard_finance')]
    public function finance(): Response
    {
        return $this->render('dashboard/finance.html.twig');
    }

    #[Route('/dashboard/blog', name: 'dashboard_blog')]
    public function blog(): Response
    {
        return $this->render('dashboard/blog.html.twig');
    }

    #[Route('/dashboard/file-manager', name: 'dashboard_file_manager')]
    public function fileManager(): Response
    {
        return $this->render('dashboard/file.html.twig');
    }
}
