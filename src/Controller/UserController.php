<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/profil/{username}', name: 'user_profil')]
    public function index(string $username, UsersRepository $usersRepo): Response
    {
        $userProfil = $usersRepo->findOneBy(["username" => $username]);
        return $this->render('user/index.html.twig', [
            'userProfil' => $userProfil,
        ]);
    }
}
