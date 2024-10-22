<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ItemService;

class ItemController extends AbstractController
{
    public function __construct(private LockerService $lockerService,
    private ItemService $itemService){
    }

    #[Route('/item/{id}/{type}', name: 'app_item')]
    public function index($id, $type): Response
    {

        $item = $this->itemService->getItem($id, $type);

        if(empty($item)){
            return $this->redirectToRoute('app_default');        
        }

        return $this->render('item/index.html.twig', [
            'controller_name' => 'ItemController',
            'item' => $item
        ]);
    }
}
