<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Form\QuackType;
use App\Repository\QuackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quack', name: 'quack')]
class QuackController extends AbstractController {
    #[Route('/', name: 'quack_list', methods:['GET'])]
    public function listQuacks(QuackRepository $quackRepository, Request $request): Response {
        $quacks = $quackRepository->findAll();
        return $this->render('quack/index.html.twig', [
            'quacks' => $quacks
        ]);
    }

    #[Route('/{id}', name: 'quack_show', requirements: ['id' => '\d+'], methods:['GET'])]
    public function showQuack(QuackRepository $quackRepository, int $id): Response {
        $quack = $quackRepository->find($id);
        return $this->render('quack/onequack.html.twig', ['quack' => $quack]);
    }

    #[Route('/newQuack', name: 'quack_add', methods:['GET', 'POST'])]
    public function addQuack(Request $request, EntityManagerInterface $entityManager): Response {
        // création d'un nouveau Quack
        $quack = new Quack();

        // Création du formulaire
        $form = $this->createForm(QuackType::class, $quack);
        /* handler */
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quackData = $form->getData();
            $entityManager->persist($quackData);
            $entityManager->flush();
            return $this->redirectToRoute('quackSuccess');
        }
        /* render */
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

    #[Route('/{id<\d+>}/delete', name: 'quack_delete', methods:['POST'])]
    public function deleteQuack(int $id): Response {
        return $this->redirectToRoute('quack_list');
    }
}
