<?php

namespace App\Controller;

use App\Entity\StudentCritere;
use App\Form\StudentCritereType;
use App\Repository\StudentCritereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/studentcritere")
 */
class StudentCritereController extends AbstractController
{
    /**
     * @Route("/", name="student_critere_index", methods={"GET"})
     */
    public function index(StudentCritereRepository $studentCritereRepository): Response
    {
        return $this->render('student_critere/index.html.twig', [
            'student_criteres' => $studentCritereRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="student_critere_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $studentCritere = new StudentCritere();
        $form = $this->createForm(StudentCritereType::class, $studentCritere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($studentCritere);
            $entityManager->flush();

            return $this->redirectToRoute('student_critere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student_critere/new.html.twig', [
            'student_critere' => $studentCritere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="student_critere_show", methods={"GET"})
     */
    public function show(StudentCritere $studentCritere): Response
    {
        return $this->render('student_critere/show.html.twig', [
            'student_critere' => $studentCritere,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="student_critere_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, StudentCritere $studentCritere, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StudentCritereType::class, $studentCritere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('student_critere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student_critere/edit.html.twig', [
            'student_critere' => $studentCritere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="student_critere_delete", methods={"POST"})
     */
    public function delete(Request $request, StudentCritere $studentCritere, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$studentCritere->getId(), $request->request->get('_token'))) {
            $entityManager->remove($studentCritere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('student_critere_index', [], Response::HTTP_SEE_OTHER);
    }
}
