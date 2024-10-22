<?php

namespace App\Controller;

use App\Service\ValorantApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{

    public function __construct(private ValorantApi $valorantApi)
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $skins = $this->valorantApi->getSkins(true);
        $bundles = $this->valorantApi->getBundles(true);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
