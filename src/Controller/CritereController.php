<?php

namespace App\Controller;

use App\Entity\Critere;
use App\Form\CritereType;
use App\Repository\CritereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/critere")
 */
class CritereController extends AbstractController
{
    /**
     * @Route("/", name="critere_index", methods={"GET"})
     */
    public function index(CritereRepository $critereRepository): Response
    {
        return $this->render('critere/index.html.twig', [
            'criteres' => $critereRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="critere_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $critere = new Critere();
        $form = $this->createForm(CritereType::class, $critere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($critere);
            $entityManager->flush();

            return $this->redirectToRoute('critere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('critere/new.html.twig', [
            'critere' => $critere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="critere_show", methods={"GET"})
     */
    public function show(Critere $critere): Response
    {
        return $this->render('critere/show.html.twig', [
            'critere' => $critere,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="critere_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Critere $critere, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CritereType::class, $critere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('critere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('critere/edit.html.twig', [
            'critere' => $critere,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="critere_delete", methods={"POST"})
     */
    public function delete(Request $request, Critere $critere, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$critere->getId(), $request->request->get('_token'))) {
            $entityManager->remove($critere);
            $entityManager->flush();
        }

        return $this->redirectToRoute('critere_index', [], Response::HTTP_SEE_OTHER);
    }
}
