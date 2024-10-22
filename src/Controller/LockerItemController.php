<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\LockerService;
use App\Service\ItemService;

class LockerItemController extends AbstractController
{
    public function __construct(private LockerService $lockerService,
    private ItemService $itemService){
    }
    
    #[Route('/locker/{id}/{itemId}', name: 'app_locker_item')]
    public function index($id, $itemId): Response
    {

        $locker = $this->lockerService->getLocker($id);

        if(empty($locker)){
            return $this->redirectToRoute('app_home');        
        }

        $item = $this->itemService->getItemByIdInLocker($locker, $id);

        if(empty($item)){
            return $this->redirectToRoute('app_home');        
        }

        $allItem = $this->itemService->getItemByTypeInLocker($locker, $item->getItemType());

        return $this->render('locker_item/index.html.twig', [
            'controller_name' => 'LockerItemController',
            'item' => $item,
            'allItem' => $allItem
        ]);
    }


}
