<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\Chroma;
use App\Repository\ChromaRepository;

class ChromaService
{


    public function __construct(
        private HttpClientInterface $client,
        private RequestStack $requestStack,
        private ChromaRepository $chromaService
    ) {

    }

    public function addChromas($chromas, $item){
        foreach ($chromas as $ch) {
            $c = new Chroma();

            $c->setDisplayIcon($ch['fullRender']);
            $c->setDisplayName($ch['displayName']);
            $c->setId($ch['uuid']);
            $c->setItem($item);

            $this->chromaService->add($c);
        }
    }


}
