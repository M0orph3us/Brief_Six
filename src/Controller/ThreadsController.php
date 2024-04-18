<?php

namespace App\Controller;

use App\Entity\Threads;
use App\Form\ThreadFormType;
use App\Repository\ResponsesRepository;
use App\Repository\ThreadsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTimeImmutable;
use DateTimeZone;

class ThreadsController extends AbstractController
{
    #[Route('/threads/detail-{id}', name: 'threads', methods: ['GET'])]
    public function index(ThreadsRepository $threadsRepo, ResponsesRepository $reponseRepo, int $id): Response
    {
        $thread = $threadsRepo->find($id);
        $responses = $thread->getResponses();
        foreach ($responses as $key => $value) {
            $idResponse = $responses[$key]->getId();
            $arrayVoteTrue[$key] = $reponseRepo->getVoteTrue($idResponse);
        }
        $user = $thread->getUsers();
        $categories = $thread->getCategories();

        $categoriesTitle = [];
        foreach ($categories as $category) {
            $categoriesTitle[] = $category->getTitle();
        }

        return $this->render('threads/index.html.twig', [
            'thread' => $thread,
            'responses' => $responses,
            'username' => $user->getUsername(),
            'userId_thread' => $user->getId(),
            'categories' => $categoriesTitle,
            'votes' => $arrayVoteTrue

        ]);
    }

    #[Route('/threads/new', name: 'thread_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $thread = new Threads();
        $form = $this->createForm(ThreadFormType::class, $thread);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $timezone = new DateTimeZone('Europe/Paris');
            $thread
                ->setUsers($user)
                ->setStatus('Open')
                ->setCreatedAt(new DateTimeImmutable('now', $timezone));
            $em->persist($thread);
            $em->flush();
            $this->addFlash('success', '');

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('threads/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('threads/edit/{id}', name: 'thread_edit', methods: ['GET', 'POST'])]
    public function edit(EntityManagerInterface $em, Request $request, Threads $thread)
    {
        $form = $this->createForm(ThreadFormType::class, $thread);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $timezone = new DateTimeZone('Europe/Paris');
            $thread->setUpdatedAt(new DateTimeImmutable('now', $timezone));

            $em->flush();
            $this->addFlash('success', 'Bien joué');

            return $this->redirectToRoute('threads', ['id' => $thread->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('threads/edit.html.twig', [
            'thread' => $thread,
            'form' => $form,
        ]);
    }

    #[Route('threads/delete/{id}', name: 'thread_delete', methods: ['POST'])]
    public function delete(EntityManagerInterface $em, Request $request, Threads $thread, ResponsesRepository $reponseRepo, int $id)
    {

        if ($this->isCsrfTokenValid('delete' . $thread->getId(), $request->getPayload()->get('_token'))) {
            $allResponses = $reponseRepo->findBy(['id' => $id]);
            if ($allResponses) {
                foreach (array_keys($allResponses) as $key) {

                    $thread->removeResponse($allResponses[$key]);
                }
            }
            $em->remove($thread);
            $em->flush();
            $this->addFlash('succes', '');
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
