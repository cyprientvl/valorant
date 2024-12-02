<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\LockerRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\SecurityBundle\Security;

class LikeService
{


    public function __construct(
        private HttpClientInterface $client,
        private RequestStack $requestStack,
        private LockerRepository $lockerRepository,
        private UserRepository $userRepository,

        private Security $security
    ) {

    }

    public function likeLocker($locker){
        $user = $this->security->getUser();  
        if(empty($user)) return;
        $locker->addLikes($user);
        $this->lockerRepository->updateLocker($locker);
    }

    public function isLiked($locker){
        $user = $this->security->getUser();  
        if(empty($user)) return;
        return $locker->isLiked($user);
    }

    public function getUserLockerLike(){
        $user = $this->security->getUser();  
        if(empty($user)) return;
        return $user->getLikedLockers();
        //return $this->userRepository->getUserLockerLike($user->getId());
    }

    


}
