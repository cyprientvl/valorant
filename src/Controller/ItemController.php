<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ItemService;
use App\Service\LockerService;
use App\Service\ChromaService;
use App\Service\LockerItemService;
use App\Service\ValorantApi;

class ItemController extends AbstractController
{
    public function __construct(private LockerService $lockerService, 
    private ItemService $itemService,
    private ChromaService $chromaService,
    private LockerItemService $lockerItemService,
    private ValorantApi $valorantApi){
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

        $chroma = null;
        foreach ($itemInDb->getChromas() as $ch) {
            if($ch->getId() == $chromaId) $chroma = $ch;
        }
        $this->lockerItemService->addLockerItem($locker, $itemInDb, $chroma);

        return $this->redirectToRoute('app_locker', ['id' => $locker->getId()]);        


    }


    #[Route('/item/{id}/{chromaId}', name: 'app_item')]
    public function index($id, $chromaId): Response
    {

        $item = $this->itemService->getItem($id, 'Melee');

        if(empty($item)){
            return $this->redirectToRoute('app_home');        
        }

        $locker = $this->lockerService->getMyLocker();

        if(empty($locker)){
            return $this->redirectToRoute('app_locker_create');        
        }

        $type = $this->itemService->getWeaponType($item['data']['displayName']);
        $chroma = null;
        foreach ($item['data']['chromas'] as $ch) {
            if($ch['uuid'] == $chromaId) $chroma = $ch;
        }
    
        if(empty($chroma)){
            return $this->redirectToRoute('app_home');        
        }

        $chromaIsInMyLocker = false;
        $itemIdInMyLocker = 0;
        $locker = $this->lockerService->getMyLocker();
        
        if(!empty($locker)){
            foreach($locker->getLockerItems() as $lockerItem){
                if($lockerItem->getChroma()->getId() == $chromaId){
                    $chromaIsInMyLocker = true;
                    $itemIdInMyLocker = $lockerItem->getId();
                }
            }
        }

        $name = explode(' ', $item['data']['displayName'])[0];

        $recomendation = $this->valorantApi->search("weapons/skins/", "displayName", $name);
        foreach ($recomendation as $key => $value) {
            $recomendation[$key]['type'] = $this->itemService->getWeaponType($recomendation[$key]['displayName']);
        }

        return $this->render('item/index.html.twig', [
            'controller_name' => 'ItemController',
            'item' => $item['data'],
            'type' => $type,
            'chroma' => $chroma,
            'chromaIsInMyLocker' => $chromaIsInMyLocker,
            'itemIdInMyLocker' => $itemIdInMyLocker,
            'lockerId' => strval($locker->getId()),
            'recomendation' => $recomendation
        ]);
    }
}
