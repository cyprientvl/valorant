<?php

namespace App\Service;

use App\Entity\Locker;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\LockerItem;

use App\Repository\LockerItemRepository;

class LockerItemService
{


    public function __construct(
        private HttpClientInterface $client,
        private RequestStack $requestStack,
        private LockerItemRepository $lockerItemRepository
    ) {

    }

    public function addLockerItem($locker, $item, $chroma = null){
        $lockerItem = new LockerItem();
        $lockerItem->setItem($item);
        
        if(isset($chroma)){
            $lockerItem->setChroma($chroma);
        }

        $lockerItem->setLocker($locker);
        
        $this->lockerItemRepository->add($lockerItem);

    }

    public function removeItem($itemId){
        $lockerItem = $this->lockerItemRepository->get($itemId);
        if(empty($lockerItem)){
            return;
        }
        $this->lockerItemRepository->remove($lockerItem);
    }

    public function updateLockerItemMainType($lockerItem){
        $lockerItem->setIsMainItemType(!$lockerItem->getIsMainItemType());
        $this->lockerItemRepository->update($lockerItem);
    }

    public function getLockerItemByIdInLocker(Locker $locker, $itemId)
    {
        $items = $locker->getLockerItems();
        foreach ($items as $item) {

            if ($item->getId() === intval($itemId)) {
                return $item;
            }
        }
    }

    public function getLockerItemByTypeInLocker(Locker $locker, $type)
    {

        $returns = [];
        $items = $locker->getLockerItems();

        foreach ($items as $item) {
            if ($item->getItem()->getItemType() === $type) {
                array_push($returns, $item);
            }
        }

        return $returns;
    }


}
