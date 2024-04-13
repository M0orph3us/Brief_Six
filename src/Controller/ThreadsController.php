<?php

namespace App\Controller;

use App\Repository\ThreadsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ThreadsController extends AbstractController
{
    #[Route('/threads/detail-{id}', name: 'threads')]
    public function index(ThreadsRepository $threadsRepo, int $id): Response
    {
        $thread = $threadsRepo->find($id);
        $user = $thread->getUsers();
        $categories = $thread->getCategories();
        $categoriesTitle = [];
        foreach ($categories as $category) {
            $categoriesTitle[] = $category->getTitle();
        }

        return $this->render('threads/index.html.twig', [
            'thread' => $thread,
            'responses' => $thread->getResponses(),
            'username' => $user->getUsername(),
            'userId' => $user->getId(),
            'categories' => $categoriesTitle
        ]);
    }
}
