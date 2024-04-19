<?php

namespace App\Controller;

use App\Entity\Responses;
use App\Entity\Votes;
use App\Form\ResponseFormType;
use App\Repository\ResponsesRepository;
use App\Repository\ThreadsRepository;
use App\Repository\VotesRepository;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ResponsesController extends AbstractController
{

    #[Route('/like/{id}', name: 'like', methods: ['GET'])]
    public function addVote(EntityManagerInterface $em, Responses $response, ResponsesRepository $responseRepo, VotesRepository $voteRepo): JsonResponse
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $responseId = $response->getId();
        $arrayVote = $responseRepo->getVoteByResponse($userId, $responseId);
        if ($arrayVote !== false) {
            if ($arrayVote['vote'] === 1) {
                $vote = $voteRepo->findOneBy(['id' => $arrayVote['id']]);
                $vote
                    ->setVote(0);
                $em->flush();
                return $this->json(['vote' => false]);
            } elseif ($arrayVote['vote'] === 0) {
                $vote = $voteRepo->findOneBy(['id' => $arrayVote['id']]);
                $vote
                    ->setVote(1);
                $em->flush();
                return $this->json(['vote' => true]);
            };
        } else {
            $vote = new Votes();
            $vote
                ->setUser($this->getUser())
                ->setVote(1);
            $response->addVote($vote);
            $em->persist($vote);
            $em->flush();
            return $this->json(['vote' => 'new']);
        };
    }
    #[Route('/response/{id}/new', name: 'response_new', methods: ['POST'])]
    public function addResponse(Request $request, EntityManagerInterface $em, int $id, ThreadsRepository $threadRepo): Response
    {
        $response = new Responses();
        $form = $this->createForm(ResponseFormType::class, $response);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $thread = $threadRepo->findOneBy(['id' => $id]);
            $timezone = new DateTimeZone('Europe/Paris');
            $response
                ->setUsers($this->getUser())
                ->setThreads($thread)
                ->setCreatedAt(new DateTimeImmutable('now', $timezone));

            $em->persist($response);
            $em->flush();
            $this->addFlash('success', '');
            return $this->redirectToRoute('threads', ['id' => $id]);
        } else {
            $this->addFlash('error', '');
            return $this->redirectToRoute('threads', ['id' => $id]);
        }

        return $this->render('responses/new.html.twig', [
            'form' => $form,
            'theadId' => $id
        ]);
    }

    #[Route('/response/{id}/delete', name: 'response_delete', methods: ['POST'])]
    public function delete(Request $request, Responses $response, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $response->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($response);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
