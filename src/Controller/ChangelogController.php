<?php

namespace App\Controller;

use App\Repository\ChangelogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ChangelogController extends AbstractController
{
    #[Route('/changelog', name: 'app_changelog')]
    public function index(ChangelogRepository $changelogRepository): Response
    {
        $groupedChangelog = $changelogRepository->findGroupedByVersion();

        return $this->render('changelog/index.html.twig', [
            'groupedChangelog' => $groupedChangelog,
        ]);
    }
}
