<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Entity\User;
use App\Form\QuackType;
use App\Repository\QuackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quack', name: 'quack')]
class QuackController extends AbstractController {
    #[Route('/', name: 'quack_list', methods:['GET'])]
    public function listQuacks(QuackRepository $quackRepository): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $quacks = $quackRepository->findAll();
        /*dd($quacks);
        $motherQuacks = $quackRepository->findMotherQuack();
        dd($motherQuacks);*/
        return $this->render('quack/index.html.twig', [
            'quacks' => $quacks
        ]);
    }

    #[Route('/newQuack', name: 'quack_add', methods:['GET', 'POST'])]
    public function addQuack(Request $request, EntityManagerInterface $entityManager): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // création d'un nouveau Quack
        $quack = new Quack();
        $userObject = $this->getUser();

        // Création du formulaire
        $form = $this->createForm(QuackType::class, $quack);
        /* handler */
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quackData = $form->getData();
            $quackData->setUserId($userObject);
            /*dd($quackData);*/
            $entityManager->persist($quackData);
            $entityManager->flush();
            return $this->redirectToRoute('quackquack_list');
        }
        /* render */
        return $this->render('quack/createquack.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id<\d+>}', name: 'quack_show', methods: ['GET'])]
    public function showQuack(QuackRepository $quackRepository, int $id): Response {
        // Need access granted to use this
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        // $quackObject return one quack identified by its id
        $quackObject = $quackRepository->find($id);
        /*dd($quackObject);*/
        /*dd($quackObject->getId());*/
        $quackChildren = $quackRepository->findByMotherQuackId($quackObject->getId());
        /*dd($quackChildren);*/
        return $this->render('quack/onequack.html.twig', [
            'user' => $user,
            'quack' => $quackObject,
            'quacks' => $quackChildren
        ]);
    }

    #[Route('/{id<\d+>}/newComment', name: 'quack_comment', methods: ['GET', 'POST'])]
    public function newComment(
        Request $request,
        EntityManagerInterface $entityManager,
        QuackRepository $quackRepository,
        int $id
    ): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        /*dd($id);*/
        $motherquackObject = $quackRepository->find($id);
        /*dd($motherquackObject);*/
        $userObject = $this->getUser();
        $quack = new Quack();

        $form = $this->createForm(QuackType::class, $quack);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quackData = $form->getData();
            $quackData->setUserId($userObject);
            $quackData->setMotherquackId($motherquackObject);
            /*dd($quackData);*/
            $entityManager->persist($quackData);
            $entityManager->flush();
            return $this->redirectToRoute('quackquack_list');
        }
        return $this->render('quack/createquack.html.twig', ['form' => $form->createView()]);

    }

    #[Route('/quackSuccess', name: 'quackSuccess', methods:'GET')]
    public function postQuackSuccess(): Response {
        return $this->render('quack/quacksuccess.html.twig', [
            'message' => 'quack created'
        ]);
    }

    #[Route('/{id<\d+>}/edit', name: 'quack_edit', methods:['GET', 'POST'])]
    public function editQuack(Quack $quack, Request $request, EntityManagerInterface $entityManager): Response {

        $this->denyAccessUnlessGranted('quack_edit', $quack);

        $form = $this->createForm(QuackType::class, $quack);
        /* handler */
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quackData = $form->getData();
            $entityManager->persist($quackData);
            $entityManager->flush();
            return $this->redirectToRoute('quackSuccess');
        }

        return $this->render('quack/editquack.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/{id<\d+>}/delete', name: 'quack_delete', methods:['GET', 'POST'])]
    public function deleteQuack(QuackRepository $quackRepository, int $id): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $quackObject = $quackRepository->find($id);
        /*dd($quackObject);*/
        /*$quackChildren = $quackRepository->findByMotherQuackId($quackObject->getId());*/
        $quackRepository->deleteQuackChildren($quackObject->getId());
        $quackRepository->deleteQuack($id);
        return $this->redirectToRoute('quackquack_list');
    }
}
