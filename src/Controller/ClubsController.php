<?php

namespace App\Controller;

use App\Entity\Clubs;
use App\Form\ClubsType;
use App\Repository\ClubsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/clubs')]
#[IsGranted('ROLE_USER')]
final class ClubsController extends AbstractController
{
    #[Route(name: 'app_clubs_index', methods: ['GET'])]
    public function index(ClubsRepository $clubsRepository): Response
    {
        return $this->render('clubs/index.html.twig', [
            'clubs' => $clubsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_clubs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $club = new Clubs();
        $form = $this->createForm(ClubsType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($club);
            $entityManager->flush();

            return $this->redirectToRoute('app_clubs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('clubs/new.html.twig', [
            'club' => $club,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_clubs_show', methods: ['GET'])]
    public function show(Clubs $club): Response
    {
        return $this->render('clubs/show.html.twig', [
            'club' => $club,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_clubs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Clubs $club, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClubsType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_clubs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('clubs/edit.html.twig', [
            'club' => $club,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_clubs_delete', methods: ['POST'])]
    public function delete(Request $request, Clubs $club, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$club->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($club);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_clubs_index', [], Response::HTTP_SEE_OTHER);
    }
}
