<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminControllerPhpController extends AbstractController
{
    #[Route('/adminDashboard', name: 'adminDashboard')]
    public function index(UserRepository $userRepository): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        /*dd($user);*/
        $allUsers = $userRepository->findAll();
        /*dd($allUsers[0]->getRoles());*/
        return $this->render('administration/dashboard.html.twig', [
            'userAdmin' => $user,
            'allUsers' => $allUsers
        ]);
    }

    #[Route('/adminDashboard/changeRole', name: 'changeRole')]
    public function changeRole(): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        dd($user->getRoles());
        return $this->render('administration/changeRole.html.twig');
    }
}
