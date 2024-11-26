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

class LockerService{

    private $baseUrl = "https://valorant-api.com/v1/";

    public function __construct(
        private HttpClientInterface $client,  
        private RequestStack $requestStack,
        private LockerRepository $lockerRepository,
        private Security $security){

        }

    public function getLocker($id){

        $user = $this->security->getUser();
        $locker = $this->lockerRepository->findLockerById($id);
        
        if(empty($locker) || ($locker->getUser()->getId() != $user->getId() && $locker->getIsPublic())){
            return null;
        }

        return $locker;
    }

    public function getMyLocker(){
        $user = $this->security->getUser();
        $locker = $this->lockerRepository->getMyLocker();
        return $locker;
    }

    public function isMyLocker($locker){
        $user = $this->security->getUser();
        return $locker->getUser()->getId() == $user->getId();
    }

    public function getWeaponInLocker($locker){      

        $weapon = [];
        foreach ($locker->getLockerItems() as $item) {
            $itemType = $item->getItem()->getItemType();
            if (!isset($weapon[$itemType])) {
                $weapon[$itemType] = [];
            }

            if ($item->getIsMainItemType()) {
                array_unshift($weapon[$itemType], $item);
            } else {
                array_push($weapon[$itemType], $item);
            }        }

        return $weapon;
    }

    public function createLocker($name){
        $locker = new Locker($name, false);
        $user = $this->security->getUser();
        $locker->setUser($user);
        $this->lockerRepository->createLocker($locker);
    }

    public function updateLocker($locker, $name = null, $isPublic = null, $likes = null){
        if(empty($locker) || !$this->isMyLocker($locker)) return;

        if(!empty($name)) $locker->setName($name);
        if(!empty($likes)) $locker->setLikes($likes);
        if(isset($isPublic)){
            $locker->setIsPublic($isPublic);
        }

        $this->lockerRepository->updateLocker($locker);

    }

    public function getTopLocker(){
        return $this->lockerRepository->getTopLocker();
    }
}
