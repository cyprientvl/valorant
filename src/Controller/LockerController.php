<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\LockerService;
use App\Form\CreateLocker;
use Symfony\Component\HttpFoundation\Request; 

class LockerController extends AbstractController
{

    public function __construct(private LockerService $lockerService){
    }

    #[Route('/locker/{id}', name: 'app_locker')]
    public function index(Request $request, $id): Response
    {

        $locker = $this->lockerService->getLocker($id);

        if(empty($locker)){
            return $this->redirectToRoute('app_default');        
        }
        
        $weapons = $this->lockerService->getWeaponInLocker($locker);

        $form = $this->createForm(UpdateLocker::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->lockerService->updateLocker($locker, $data['name'], $data['isPublic']);
            return $this->redirectToRoute('app_locker');        
        }

        return $this->render('locker/locker.html.twig', [
            'controller_name' => 'LockerController',
            'locker' => $locker,
            'weapon' => $weapons,
            'isMyLocker' => $this->lockerService->isMyLocker()
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

}
