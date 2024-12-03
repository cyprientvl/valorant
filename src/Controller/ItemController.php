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
use App\Repository\LockerItemRepository;

class ItemController extends AbstractController
{
    public function __construct(
        private LockerService $lockerService,
        private ItemService $itemService,
        private ChromaService $chromaService,
        private LockerItemService $lockerItemService,
        private ValorantApi $valorantApi,
        private LockerItemRepository $lockerItemRepository,
    ) {
    }


    #[Route('/item/add/{id}/{chromaId}', name: 'app_item_create')]
    public function add($id, $chromaId)
    {
        $item = null;
        $isOther = true;

        if ($chromaId == 'playerTitle' || $chromaId == 'playerCard' || $chromaId == 'spray') {
            $item = $this->itemService->getItem($id, $chromaId);
        } else {
            $isOther = false;
            $item = $this->itemService->getItem($id, 'Melee');
        }

        $locker = $this->lockerService->getMyLocker();

        if (empty($item) || empty($locker)) {
            return $this->redirectToRoute('app_home');
        }
        $item = $item['data'];
        $itemInDb = $this->itemService->getItemInBd($id);

        if (empty($itemInDb)) {

            $keyIconName = "displayIcon";

            if($chromaId == 'playerCard'){
                $keyIconName = "largeArt";
            }

            $displayIcon = $item[$keyIconName] ?? "";
            $itemType = $this->itemService->getWeaponType($item['displayName']);

            if ($isOther) {
                $itemType = $chromaId;
            }

            $this->itemService->addItem($id, $item['displayName'], $itemType, $displayIcon);
            $itemInDb = $this->itemService->getItemInBd($id);
            if (!$isOther) {
                $this->chromaService->addChromas($item['chromas'], $itemInDb);
            }
        }

        $chroma = null;
        foreach ($itemInDb->getChromas() as $ch) {
            if ($ch->getId() == $chromaId)
                $chroma = $ch;
        }
        $this->lockerItemService->addLockerItem($locker, $itemInDb, $chroma);

        return $this->redirectToRoute('app_locker', ['id' => $locker->getId()]);


    }

    #[Route('/item/other/{id}/{type}', name: 'app_item_other')]
    public function showOther(string $id, string $type): Response
    {
        $item = $this->itemService->getItem($id, $type);
        if (empty($item)) {
            return $this->redirectToRoute('app_home');
        }

        $item = $item['data'];

        $recomendation = $this->valorantApi->search($this->itemService->getUrlByItemType($type), "displayName", '');
        $recomendation = array_slice($recomendation, 0, 5);

        $lockerItem = $this->lockerItemRepository->getByItemId($id);
        $inMyLocker = false;
        if (!empty($lockerItem)) {
            $inMyLocker = true;
        }

        $locker = $this->lockerService->getMyLocker();
        if(empty($locker)){
            return $this->redirectToRoute('app_locker_create');        
        }

        $lockerId = $locker->getId();


        return $this->render('item/other.html.twig', [
            'controller_name' => 'ItemController',
            'id' => $id,
            'type' => $type,
            'item' => $item,
            'recomendation' => $recomendation,
            'inMyLocker' => $inMyLocker,
            'lockerId' => $lockerId
        ]);
    }


    #[Route('/item/{id}/{chromaId}', name: 'app_item')]
    public function index($id, $chromaId): Response
    {

        $item = $this->itemService->getItem($id, 'Melee');

        if (empty($item)) {
            return $this->redirectToRoute('app_home');
        }

        $locker = $this->lockerService->getMyLocker();

        if(empty($locker)){
            return $this->redirectToRoute('app_locker_create');        
        }

        $type = $this->itemService->getWeaponType($item['data']['displayName']);
        $chroma = null;
        foreach ($item['data']['chromas'] as $ch) {
            if ($ch['uuid'] == $chromaId)
                $chroma = $ch;
        }

        if (empty($chroma)) {
            return $this->redirectToRoute('app_home');
        }

        $chromaIsInMyLocker = false;
        $itemIdInMyLocker = 0;
        $locker = $this->lockerService->getMyLocker();

        if (!empty($locker)) {
            foreach ($locker->getLockerItems() as $lockerItem) {

                if (!empty($lockerItem->getChroma()) && $lockerItem->getChroma()->getId() == $chromaId) {
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
