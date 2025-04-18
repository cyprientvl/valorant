<?php

namespace App\Controller;

use App\Service\ValorantApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\LikeService;
use App\Service\LockerService;
use App\Service\ItemService;
use App\Service\LockerItemService;

class LikeController extends AbstractController
{

    public function __construct(private ValorantApi $valorantApi, 
    private LockerService $lockerService,
    private LockerItemService $lockerItemService,
    private ItemService $itemService,
    private LikeService $likeService)
    {
    }

    #[Route('/like', name: 'app_like_index')]
    public function index(): Response{
        
        $lockers = $this->likeService->getUserLockerLike();

        $lockers = $this->lockerService->setLockerBanner($lockers);    
        
        return $this->render('like/index.html.twig', [
            'controller_name' => 'LockerController',
            'lockers' => $lockers
        ]);
    }

    #[Route('/locker/{id}/like', name: 'app_like')]
    public function like($id): Response{
        
        $locker = $this->lockerService->getLocker($id);
        
        if(empty($locker) || !$locker->isPublic() || $this->lockerService->isMyLocker($locker) ){
            return $this->redirectToRoute('app_home');        
        }

        $this->likeService->likeLocker($locker);

        return $this->redirectToRoute('app_locker', ['id' => $id]);        
    }
}
