<?php

namespace App\Controller;

use App\Entity\Quack;
use App\Repository\QuackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quack', name: 'quack')]
class QuackController extends AbstractController {
    #[Route('/', name: 'quack_list', methods:['GET'])]
    public function listQuacks(QuackRepository $quackRepository, Request $request): Response {
        $quacks = $quackRepository->findAll();
        return $this->render('quack/index.html.twig', ['quacks' => $quacks]);
    }

    #[Route('/{id}', name: 'quack_show', requirements: ['id' => '\d+'], methods:['GET'])]
    public function showQuack(QuackRepository $quackRepository, int $id): Response {
        $quack = $quackRepository->find($id);
        return $this->render('quack/onequack.html.twig', ['quack' => $quack]);
    }

    #[Route('/newQuack', name: 'quack_add', methods:['GET', 'POST'])]
    public function addQuack(EntityManagerInterface $entityManager, Request $request) {
        $quack = new Quack();
        $quack->setTitle('Title');
        $quack->setContent('Contenu du quack');
        $quack->setCreatedAt();

        $entityManager->persist($quack);

        $entityManager->flush();

        return $this->render('quack/createquack.html.twig', ['quack' => $quack]);

    }

    #[Route('/{id<\d+>}/edit', name: 'quack_edit', methods:['GET', 'POST'])]
    public function editQuack(): Response {
        return $this->render('quack/', [
            'message' => 'your quack has been updated'
        ]);
    }

    #[Route('/{id<\d+>}/delete', name: 'quack_delete', methods:['POST'])]
    public function deleteQuack(int $id): Response {
        return $this->redirectToRoute('quack_list');
    }
}
