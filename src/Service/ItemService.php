<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\LockerRepository;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Locker;

class ItemService{


    public function __construct(
        private HttpClientInterface $client,  
        private RequestStack $requestStack,
        private LockerRepository $lockerRepository,
        private Security $security){

        }

        public function getItemByIdInLocker(Locker $locker, $itemId)
        {
            $items = $locker->getItems();
        
            foreach ($items as $item) {
                if ($item->getId() === $itemId) {
                    return $item;
                }
            }
        
            return null;
        }

        public function getItemByTypeInLocker(Locker $locker, $type){
            
            $returns = [];
            $items = $locker->getItems();
        

            foreach ($items as $item) {
                if ($item->getItemType() === $type) {
                    array_push($returns, $item);
                }
            }

            return $returns;
        }
}
