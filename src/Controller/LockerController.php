<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\LockerService;
use App\Form\CreateLocker;
use App\Form\SearchLocker;
use App\Form\UpdateLocker;
use App\Service\ItemService;
use App\Service\LikeService;
use App\Service\LockerItemService;
use Symfony\Component\HttpFoundation\Request; 

class LockerController extends AbstractController
{

    public function __construct(private LockerService $lockerService,
    private ItemService $itemService,
    private LockerItemService $lockerItemService,
    private LikeService $likeService){
    }

    #[Route('/top-locker', name: 'app_locker_top')]
    public function topLocker(Request $request){

        $form = $this->createForm(SearchLocker::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            return $this->redirectToRoute('app_locker_top', ['name' => $data['name']]);        
        }

        $name = $request->query->get('name');
        $lockers = [];
        
        if(!empty($name)){
            $lockers = $this->lockerService->searchLocker($name);
        }else{
            $lockers = $this->lockerService->getTopLocker();
        }

        $totalLocker = $this->lockerService->getTotalLocker();

        usort($lockers, function ($a, $b) {
            return $b->getLikes() - $a->getLikes(); 
        });      
        
        $lockers = $this->lockerService->setLockerBanner($lockers);

        $poduim = $this->lockerService->getLockerPoduim();

        usort($poduim, function ($a, $b) {
            return $b->getLikes() - $a->getLikes(); 
        });      
        
        $poduim = $this->lockerService->setLockerBanner($poduim);
        
        return $this->render('locker/top-locker.html.twig', [
            'controller_name' => 'LockerController',
            'lockers' =>$lockers,
            'poduim' => $poduim,
            'totalLocker' => $totalLocker,
            'formSearch' => $form 
        ]);
    }

    #[Route('/locker/create', name: 'app_locker_create')]
    public function create(Request $request): Response
    {
        $locker = $this->lockerService->getMyLocker();

        if(!empty($locker)){
            return $this->redirectToRoute('app_locker', ['id' => $locker->getId()]);        
        }

        $form = $this->createForm(CreateLocker::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->lockerService->createLocker($data['name']);
            $newLocker = $this->lockerService->getMyLocker();

            return $this->redirectToRoute('app_locker', ['id' => $newLocker->getId()]);        
        }

        return $this->render('locker/create.html.twig', [
            'controller_name' => 'LockerController',
            'form' =>$form 
        ]);
    }

    #[Route('/locker/{id}/update-public', name: 'app_locker_public')]
    public function updatePublic($id): Response {

        $locker = $this->lockerService->getMyLocker();

        if(empty($locker)){
            return $this->redirectToRoute('app_locker_create');        
        }

        if(intval($id) != $locker->getId()){
            return $this->redirectToRoute('app_home');       
        }
        $this->lockerService->updateLocker($locker, $locker->getName(), !$locker->isPublic());

        return $this->redirectToRoute('app_locker', ['id' => $id]);        
    }

    #[Route('/locker/{id}', name: 'app_locker')]
    public function index(Request $request, $id): Response
    {

        $locker = $this->lockerService->getLocker($id);

        if(empty($locker)){
            return $this->redirectToRoute('app_home');        
        }
        
        $isLiked = $this->likeService->isLiked($locker);
        $weapons = $this->lockerService->getWeaponInLocker($locker);
        
        $form = $this->createForm(UpdateLocker::class, ['name' => $locker->getName()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->lockerService->updateLocker($locker, $data['name']);
            return $this->redirectToRoute('app_locker', ['id' => $id]);        
        }

        return $this->render('locker/locker.html.twig', [
            'controller_name' => 'LockerController',
            'locker' => $locker,
            'weapons' => $weapons,
            'isMyLocker' => $this->lockerService->isMyLocker($locker),
            'updateForm' => $form,
            'isLiked' => $isLiked
        ]);
    }

    

}
