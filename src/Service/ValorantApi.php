<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ValorantApi{

    private $baseUrl = "https://valorant-api.com/v1/";

    public function __construct(
        private HttpClientInterface $client,  
        private RequestStack $requestStack){

        }

    public function get($url){

        $response = $this->client->request('GET', $this->baseUrl . $url, [
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $data = $response->toArray();
        return $data;
    }
}
