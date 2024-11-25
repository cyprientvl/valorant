<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\LockerItem;

use App\Repository\LockerItemRepository;

class LockerItemService
{


    public function __construct(
        private HttpClientInterface $client,
        private RequestStack $requestStack,
        private LockerItemRepository $lockerRepository
    ) {

    }

    public function addLockerItem($locker, $item, $chroma = null){
        $lockerItem = new LockerItem();
        $lockerItem->setItem($item);
        
        if(isset($chroma)){
            $lockerItem->setChroma($chroma);
        }

        $lockerItem->setLocker($locker);
        
        $this->lockerRepository->add($lockerItem);

    }

    public function removeItem($locker, $itemId){
            
    }


}
