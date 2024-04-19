<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
    public function edit(Request $request, EntityManagerInterface $em, Users $user, UserPasswordHasherInterface $userPasswordHasher): Response
    {

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $timezone = new DateTimeZone('Europe/Paris');
            $user
                ->setUpdatedAt(new DateTimeImmutable('now', $timezone))
                ->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            $em->flush();
            $this->addFlash('success', '');

            return $this->redirectToRoute('profil', ['username' => $user->getUsername()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('user/edit.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }

    #[Route('profil/delete/{id}', name: 'profil_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $em, Users $user, Security $security): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->getPayload()->get('_token'))) {
            $allVotes = $user->getVotes();
            $allThreads = $user->getThreads();
            $allResponses = $user->getResponses();


            if (!empty($allVotes)) {
                foreach ($allVotes as $vote) {
                    $user->removeVote($vote);
                }
            }
            if (!empty($allResponses)) {
                foreach ($allResponses as $response) {
                    $user->removeResponse($response);
                }
            }
            if (!empty($allThreads)) {
                foreach ($allThreads as $thread) {
                    $user->removeThread($thread);
                }
            }

            $em->remove($user);
            $em->flush();
            $response = $security->logout();
            $this->addFlash('success', '');
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        } else {
            $this->addFlash('error', 'Not valid CSRF token ');
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }
    }
}
