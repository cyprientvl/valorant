<?php

namespace App\Controller;

use App\Form\LockerItemForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\LockerService;
use App\Service\ItemService;
use App\Service\LockerItemService;
use App\Service\ValorantApi;
use Symfony\Component\HttpFoundation\Request; 

class LockerItemController extends AbstractController
{
    public function __construct(private LockerService $lockerService,
    private ItemService $itemService,
    private LockerItemService $lockerItemService,
    private ValorantApi $valorantApi){
    }

    #[Route('/locker/{id}/other/{itemId}', name: 'app_locker_item_other')]
    public function other(Request $request, $id, $itemId): Response
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
        
        $formUpdate = $this->createForm(LockerItemForm::class, ['name' => $locker->getName()]);
        $formUpdate->handleRequest($request);

        if ($formUpdate->isSubmitted() && $formUpdate->isValid()) {

            $this->lockerItemService->updateLockerItemMainType($item);

            return $this->redirectToRoute('app_locker_item_other', ['id' => $id, 'itemId' => $itemId]);        
        }

        return $this->render('locker_item/other.html.twig', [
            'controller_name' => 'LockerItemController',
            'item' => $item,
            'type' => $item->getItem()->getItemType(),
            'allItem' => $allItem,
            'lockerId' => $id,
            'lockerItemId' => $itemId,
            'isMyLocker' => $this->lockerService->isMyLocker($locker),
            'formUpdate' => $formUpdate,
        ]);
    }
    
    #[Route('/locker/{id}/{itemId}', name: 'app_locker_item')]
    public function index(Request $request, $id, $itemId): Response
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
        $formUpdate = $this->createForm(LockerItemForm::class, ['name' => $locker->getName()]);
        $formUpdate->handleRequest($request);

        if ($formUpdate->isSubmitted() && $formUpdate->isValid()) {

            $this->lockerItemService->updateLockerItemMainType($item);

            return $this->redirectToRoute('app_locker_item', ['id' => $id, 'itemId' => $itemId]);        
        }


        return $this->render('locker_item/index.html.twig', [
            'controller_name' => 'LockerItemController',
            'item' => $item,
            'allItem' => $allItem,
            'lockerId' => $id,
            'lockerItemId' => $itemId,
            'isMyLocker' => $this->lockerService->isMyLocker($locker),
            'formUpdate' => $formUpdate,
        ]);
    }

    #[Route('/locker/{id}/delete/{itemId}', name: 'app_locker_item_delete')]
    public function delete($id, $itemId): Response{
        $locker = $this->lockerService->getLocker($id);

        if(empty($locker) || !$this->lockerService->isMyLocker($locker)){
            return $this->redirectToRoute('app_home');        
        }
        $this->lockerItemService->removeItem($itemId);

        return $this->redirectToRoute('app_locker', ['id' => $id]);        
    }

}
