<?php

namespace App\Controller;

use App\Service\StatsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{
    public function __construct(
        private StatsService $statsService
    ) {
    }

    #[Route('/stats', name: 'app_stats')]
    public function index(): Response
    {
        return $this->render('stats/index.html.twig', [
            'mostUsedSkins' => $this->statsService->getMostUsedSkins(),
            'mostUsedWeaponChromas' => $this->statsService->getMostUsedWeaponChromas(),
            'mostLikedSkins' => $this->statsService->getMostLikedSkinsByLockers(),
            'topUsers' => $this->statsService->getUsersWithMostItems(),
        ]);
    }
}
