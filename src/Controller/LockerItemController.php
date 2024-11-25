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

        if(empty($locker) || (!$locker->isPublic() && !$this->lockerService->isMyLocker($locker))){
            return $this->redirectToRoute('app_home');        
        }

        $item = $this->itemService->getItemByIdInLocker($locker, $itemId);

        if(empty($item)){
            return $this->redirectToRoute('app_home');        
        }
        $allItem = $this->itemService->getItemByTypeInLocker($locker, $item->getItem()->getItemType());


        return $this->render('locker_item/index.html.twig', [
            'controller_name' => 'LockerItemController',
            'item' => $item,
            'allItem' => $allItem,
            'lockerId' => $id
        ]);
    }

    #[Route('/locker/{id}/delete/{itemId}', name: 'app_locker_item_delete')]
    public function delete($id, $itemId): Response{
        $locker = $this->lockerService->getLocker($id);

        if(empty($locker) || !$this->lockerService->isMyLocker($locker)){
            return $this->redirectToRoute('app_home');        
        }

        

    }

}
