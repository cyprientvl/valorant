<?php

namespace App\Controller;

use App\Form\SearchFormType;
use App\Service\ValorantApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    public function __construct(private ValorantApi $valorantApi)
    {
    }

    #[Route('/search', name: 'app_search')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(SearchFormType::class);
        $form->handleRequest($request);

        $items = [];
        $query = $request->query->get('q', '');
        $type = $request->query->get('type', '');

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $query = $data['q'];
            $type = $data['type'];

            if (!$type) {
                $this->addFlash('error', 'Veuillez sélectionner un type de recherche.');
                return $this->redirectToRoute('app_search');
            }

            $items = $this->searchItems($type, $query);

            return $this->redirectToRoute('app_search', [
                'q' => $query,
                'type' => $type,
            ]);
        }

        if ($query && $type) {
            $items = $this->searchItems($type, $query);
        }

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
            'items' => $items,
            'query' => $query,
            'type' => $type,
        ]);
    }

    private function searchItems(string $type, string $query): array
    {
        switch ($type) {
            case 'skins':
                return $this->valorantApi->search('weapons/skins', 'displayName', $query);
            case 'cards':
                return $this->valorantApi->search('playercards', 'displayName', $query);
            case 'titles':
                return $this->valorantApi->search('playertitles', 'displayName', $query);
            case 'sprays':
                return $this->valorantApi->search('sprays', 'displayName', $query);
            default:
                return [];
        }
    }
}
