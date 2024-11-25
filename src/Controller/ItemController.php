<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ItemService;
use App\Service\LockerService;
use App\Service\ChromaService;
use App\Service\LockerItemService;

class ItemController extends AbstractController
{
    public function __construct(private LockerService $lockerService, 
    private ItemService $itemService,
    private ChromaService $chromaService,
    private LockerItemService $lockerItemService){
    }


    #[Route('/item/add/{id}/{chromaId}', name: 'app_item_create')]
    public function add($id, $chromaId){

        $item = $this->itemService->getItem($id, 'Melee');
        $locker = $this->lockerService->getMyLocker();

        if(empty($item) || empty($locker)){
            return $this->redirectToRoute('app_home');        
        }
        $item = $item['data'];
        $itemInDb = $this->itemService->getItemInBd($id);

        if(empty($itemInDb)){
            $this->itemService->addItem($id, $item['displayName'], $this->itemService->getWeaponType($item['displayName']), $item['displayIcon']);
            $itemInDb = $this->itemService->getItemInBd($id);
            $this->chromaService->addChromas($item['chromas'], $itemInDb);
        }

        $itemInDb = $this->itemService->getItemInBd($id);
        $chroma = null;
        foreach ($itemInDb->getChromas() as $ch) {
            if($ch->getId() == $chromaId) $chroma = $ch;
        }

        $this->lockerItemService->addLockerItem($locker, $itemInDb, $chroma);

        return $this->redirectToRoute('app_locker', ['id' => $locker->getId()]);        


    }


    #[Route('/item/{id}/{chromaId}/{type}', name: 'app_item')]
    public function index($id, $chromaId, $type): Response
    {

        $item = $this->itemService->getItem($id, $type);

        if(empty($item)){
            return $this->redirectToRoute('app_home');        
        }
        $chroma = null;
        foreach ($item['data']['chromas'] as $ch) {
            if($ch['uuid'] == $chromaId) $chroma = $ch;
        }
    
        if(empty($chroma)){
            return $this->redirectToRoute('app_home');        
        }

        $chromaIsInMyLocker = false;
        $locker = $this->lockerService->getMyLocker();
        
        if(!empty($locker)){
            foreach($locker->getLockerItems() as $lockerItem){
                if($lockerItem->getChroma()->getId() == $chromaId) $chromaIsInMyLocker = true;
            }
        }

        return $this->render('item/index.html.twig', [
            'controller_name' => 'ItemController',
            'item' => $item['data'],
            'type' => $type,
            'chroma' => $chroma,
            'chromaIsInMyLocker' => $chromaIsInMyLocker,
            'lockerId' => strval($locker->getId())
        ]);
    }
}
