<?php

namespace App\Controller;

use App\Entity\Quack;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quack', name: 'quack')]
class QuackController extends AbstractController
{
    #[Route('/', name: '_home_page', methods:['get'])]
    public function getAllQuacks(): Response
    {
        return $this->render('quack/index.html.twig', [
            'controller_name' => 'Home',
        ]);
    }

    #[Route('/newQuack', name: '_create_quack', methods:['post'])]
    public function createQuack(): Response
    {
        return $this->render('quack/quacks.html.twig', [
            'controller_name' => 'New Quack'
        ]);
    }

    #[Route('/{id}', name: '_one_quack', methods:['get'])]
    public function getOneQuack(EntityManagerInterface $entityManager, int $id): Response
    {
        $quack = $entityManager->getRepository(Quack::class)->find($id);
        if(!$quack) {
            throw $this->createNotFoundException(
                'Quack not found for id '.$id
            );
        }
        return new Response('Here is your quack: '.$quack->getContent());
        // return $this->render('quack/yourquack.html.twig', ['quack' => $quack]);
    }

    #[Route('/{id}', name: '_update_quack', methods:['put'])]
    public function updateQuack(): Response
    {
        return $this->render('quack/', [
            'message' => 'your quack has been updated'
        ]);
    }

    #[Route('/{id}', name: '_delete_quack', methods:['delete'])]
    public function deleteQuack(): Response
    {
        return $this->render('quack/', [
            'message' => 'your quack has been deleted'
        ]);
    }
}
