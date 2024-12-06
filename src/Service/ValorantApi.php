<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ValorantApi
{

    private $baseUrl = "https://valorant-api.com/v1/";

    public function __construct(
        private HttpClientInterface $client,
        private RequestStack $requestStack
    ) {

    }

    public function get($url)
    {

        $response = $this->client->request('GET', $this->baseUrl . $url, [
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $data = $response->toArray();
        return $data;
    }

    public function search($url, $param, $query): array
    {
        $response = $this->client->request('GET', $this->baseUrl . $url, [
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $data = $response->toArray();

        if (!$param) {
            $param = 'displayName';
        }
        if (!$query) {
            $query = '';
        }

        $query = strtolower($query);
        $items = [];
        for ($i = 0; $i < count($data['data']); $i++) {
            if (strpos(strtolower($data['data'][$i][$param]), $query) !== false) {
                $items[] = $data['data'][$i];
                if (count($items) >= 20) {
                    break;
                }
            }
        }

        return $items;

    }

    public function getSkins(bool $isHome): array
    {
        $url = 'weapons/skins';
        $response = $this->client->request('GET', $this->baseUrl . $url, [
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $skins = $response->toArray();

        if ($isHome) {
            $homeSkins = [];
            for ($i = 0; $i < 3; $i++) {
                $homeSkins[] = $skins['data'][rand(0, count($skins['data']) - 1)];
            }
            return $homeSkins;
        }

        return $skins;
    }

    public function getBundles(bool $isHome): array
    {
        $url = 'bundles';
        $response = $this->client->request('GET', $this->baseUrl . $url, [
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);
        $bundles = $response->toArray();

        if ($isHome) {
            $homeBundles = [];
            for ($i = 0; $i < 3; $i++) {
                $homeBundles[] = $bundles['data'][rand(0, count($bundles['data']) - 1)];
            }
            return $homeBundles;
        }

        return $bundles;
    }
}
