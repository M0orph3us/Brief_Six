<?php

namespace App\Controller;

use App\Repository\ThreadsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ThreadsRepository $threadsRepository): Response
    {

        return $this->render('home_page/index.html.twig', [
            'threads' => $threadsRepository->findAll(),
        ]);
    }
}
