<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/components', name: 'components_')]
final class ComponentsController extends AbstractController
{
    #[Route('/accordions', name: 'accordions')]
    public function accordions(): Response
    {
        return $this->render('components/accordions.html.twig');
    }

    #[Route('/alerts', name: 'alerts')]
    public function alerts(): Response
    {
        return $this->render('components/alerts.html.twig');
    }

    #[Route('/avatar', name: 'avatar')]
    public function avatar(): Response
    {
        return $this->render('components/avatar.html.twig');
    }

    #[Route('/badge', name: 'badge')]
    public function badge(): Response
    {
        return $this->render('components/badge.html.twig');
    }

    #[Route('/breadcrumb', name: 'breadcrumb')]
    public function breadcrumb(): Response
    {
        return $this->render('components/breadcrumb.html.twig');
    }

    #[Route('/buttons', name: 'buttons')]
    public function buttons(): Response
    {
        return $this->render('components/buttons.html.twig');
    }

    #[Route('/card', name: 'card')]
    public function card(): Response
    {
        return $this->render('components/card.html.twig');
    }

    #[Route('/carousel', name: 'carousel')]
    public function carousel(): Response
    {
        return $this->render('components/carousel.html.twig');
    }

    #[Route('/collapse', name: 'collapse')]
    public function collapse(): Response
    {
        return $this->render('components/collapse.html.twig');
    }

    #[Route('/colors', name: 'colors')]
    public function colors(): Response
    {
        return $this->render('components/colors.html.twig');
    }

    #[Route('/dropdowns', name: 'dropdowns')]
    public function dropdowns(): Response
    {
        return $this->render('components/dropdowns.html.twig');
    }

    #[Route('/forms', name: 'forms')]
    public function forms(): Response
    {
        return $this->render('components/forms.html.twig');
    }

    #[Route('/forms-floating', name: 'forms_floating')]
    public function formsFloating(): Response
    {
        return $this->render('components/forms-floating.html.twig');
    }

    #[Route('/list-group', name: 'list_group')]
    public function listGroup(): Response
    {
        return $this->render('components/list-group.html.twig');
    }

    #[Route('/modal', name: 'modal')]
    public function modal(): Response
    {
        return $this->render('components/modal.html.twig');
    }

    #[Route('/navs-tabs', name: 'navs_tabs')]
    public function navsTabs(): Response
    {
        return $this->render('components/navs-tabs.html.twig');
    }

    #[Route('/offcanvas', name: 'offcanvas')]
    public function offcanvas(): Response
    {
        return $this->render('components/offcanvas.html.twig');
    }

    #[Route('/pagination', name: 'pagination')]
    public function pagination(): Response
    {
        return $this->render('components/pagination.html.twig');
    }

    #[Route('/placeholders', name: 'placeholders')]
    public function placeholders(): Response
    {
        return $this->render('components/placeholders.html.twig');
    }

    #[Route('/popovers', name: 'popovers')]
    public function popovers(): Response
    {
        return $this->render('components/popovers.html.twig');
    }

    #[Route('/progress', name: 'progress')]
    public function progress(): Response
    {
        return $this->render('components/progress.html.twig');
    }

    #[Route('/scrollspy', name: 'scrollspy')]
    public function scrollspy(): Response
    {
        return $this->render('components/scrollspy.html.twig');
    }

    #[Route('/shadows', name: 'shadows')]
    public function shadows(): Response
    {
        return $this->render('components/shadows.html.twig');
    }

    #[Route('/spinners', name: 'spinners')]
    public function spinners(): Response
    {
        return $this->render('components/spinners.html.twig');
    }

    #[Route('/tables', name: 'tables')]
    public function tables(): Response
    {
        return $this->render('components/tables.html.twig');
    }

    #[Route('/toasts', name: 'toasts')]
    public function toasts(): Response
    {
        return $this->render('components/toasts.html.twig');
    }

    #[Route('/tooltips', name: 'tooltips')]
    public function tooltips(): Response
    {
        return $this->render('components/tooltips.html.twig');
    }

    #[Route('/typography', name: 'typography')]
    public function typography(): Response
    {
        return $this->render('components/typography.html.twig');
    }
}
