<?php

namespace App\Controller;

use App\Entity\Quack;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quack', name: 'quack')]
class QuackController extends AbstractController {
    #[Route('/', name: 'quack_list', methods:['GET'])]
    public function listQuacks(): Response {
        return $this->render('quack/index.html.twig');
    }

    #[Route('/{id}', name: 'quack_show', requirements: ['id' => '\d+'], methods:['GET'])]
    public function showQuack(int $id): Response {
        return $this->render('quack/yourquack.html.twig', ['quack' => $quack]);
    }

    #[Route('/newQuack', name: 'quack_add', methods:['GET', 'POST'])]
    public function addQuack(Request $request) {
        if ($request->isMethod('POST')) {
            $content = $request->request->get('content');
        } else {

        }
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
