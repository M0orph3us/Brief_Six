<?php

namespace App\Controller;

use App\Entity\Responses;
use App\Entity\Votes;
use App\Repository\ResponsesRepository;
use App\Repository\VotesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
}