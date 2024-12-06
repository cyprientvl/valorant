<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\LockerRepository;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Locker;

class LockerService{

    public function __construct(
        private HttpClientInterface $client,  
        private RequestStack $requestStack,
        private LockerRepository $lockerRepository,
        private LockerItemService $lockerItemService,
        private Security $security){}

    public function getLocker($id){

        $user = $this->security->getUser();
        $locker = $this->lockerRepository->findLockerById($id);
        
        if(empty($locker) || ($locker->getUser()->getId() != $user->getId() && !$locker->isPublic())){
            return null;
        }

        return $locker;
    }

    public function getMyLocker(){
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

    public function updateLocker($locker, $name = null, $isPublic = null){
        if(empty($locker) || !$this->isMyLocker($locker)) return;

        if(!empty($name)) $locker->setName($name);
        if(isset($isPublic)){
            $locker->setIsPublic($isPublic);
        }

        $this->lockerRepository->updateLocker($locker);

    }

    public function getTopLocker(){
        return $this->lockerRepository->getTopLocker();
    }

    public function getTotalLocker(){
        return $this->lockerRepository->getTotalLocker();
    }

    public function searchLocker($search){
        return $this->lockerRepository->getLockerByusername($search);
    }

    public function getLockerPoduim(){
        return $this->lockerRepository->getLockerPoduim();
    }

    public function setLockerBanner($lockers){
        foreach ($lockers as $l) {
            $banners = $this->lockerItemService->getLockerItemByTypeInLocker($l, 'playerCard');
            if(!empty($banners[0])){
                $l->banner = $banners[0]->getItem()->getDisplayIcon();
            }
        }

        return $lockers;
    }
  
}
