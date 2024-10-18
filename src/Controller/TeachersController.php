<?php

namespace App\Controller;

use App\Entity\Teachers;
use App\Form\TeachersType;
use App\Repository\TeachersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/teachers')]
#[IsGranted('ROLE_USER')]
final class TeachersController extends AbstractController
{
    
    #[Route(name: 'app_teachers_index', methods: ['GET'])]
    public function index(TeachersRepository $teachersRepository): Response
    {
        return $this->render('teachers/index.html.twig', [
            'teachers' => $teachersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_teachers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $teacher = new Teachers();
        $form = $this->createForm(TeachersType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($teacher);
            $entityManager->flush();

            return $this->redirectToRoute('app_teachers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teachers/new.html.twig', [
            'teacher' => $teacher,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_teachers_show', methods: ['GET'])]
    public function show(Teachers $teacher): Response
    {
        return $this->render('teachers/show.html.twig', [
            'teacher' => $teacher,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_teachers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Teachers $teacher, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TeachersType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_teachers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teachers/edit.html.twig', [
            'teacher' => $teacher,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_teachers_delete', methods: ['POST'])]
    public function delete(Request $request, Teachers $teacher, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teacher->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($teacher);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_teachers_index', [], Response::HTTP_SEE_OTHER);
    }
}
