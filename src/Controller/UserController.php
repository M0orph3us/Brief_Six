<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/profil/{username}', name: 'profil', methods: ['GET'])]
    public function index(Users $user): Response
    {
        $allThreads = $user->getThreads();
        $allResponses = $user->getResponses();
        return $this->render('user/index.html.twig', [
            'user' => $user,
            'threads' => $allThreads,
            'responses' => $allResponses
        ]);
    }

    #[Route('profil/edit/{id}', name: 'profil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $em, Users $user): Response
    {

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $timezone = new DateTimeZone('Europe/Paris');
            $user->setUpdatedAt(new DateTimeImmutable('now', $timezone));
            $em->flush();
            $this->addFlash('success', '');

            return $this->redirectToRoute('profil_edit', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('user/update.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }

    #[Route('profil/delete/{id}', name: 'profil_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $em, Users $user)
    {
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', '');
    }
}