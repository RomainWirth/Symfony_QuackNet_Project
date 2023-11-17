<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController {
    #[Route('/user', name: 'profile')]
    public function index(): Response {
        // usually you'll want to make sure the user is authenticated first,
        // see "Authorization" below
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        return $this->render('user/index.html.twig', [
            'user' => $user,
            'controller_name' => 'UserController',
        ]);
    }

    /*#[Route('/user/update/{id}', name: 'update_profile')]
    public function updateUser(User $user, Request $request, EntityManagerInterface $manager): Response {
        if($this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        if($this->getUser() !== $user) {
            return $this->redirectToRoute('quackquack_list');
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $manager-> persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Information updated correctly'
            );
            return $this->redirectToRoute('profile');
        }
        return $this->render('user/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }*/
}
