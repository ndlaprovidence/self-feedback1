<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Form\ClassesType;
use App\Repository\ClassesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/classes")
 */
class ClassesController extends AbstractController
{
    /**
     * @Route("/", name="classes_index", methods={"GET"})
     */
    public function index(ClassesRepository $classesRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('classes/index.html.twig', [
            'classes' => $classesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="classes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');
        
        $class = new Classes();
        $form = $this->createForm(ClassesType::class, $class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($class);
            $entityManager->flush();

            return $this->redirectToRoute('classe_valid', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/new.html.twig', [
            'class' => $class,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/valid", name="classe_valid", methods={"GET"})
     */
    function valid(): Response
    {
        
        return $this->render('classes/valid.html.twig', [
            'titre' => 'La classe a étais enregisté !',
        ]);
    }

    /**
     * @Route("/{id}", name="classes_show", methods={"GET"})
     */
    public function show(Classes $class): Response
    {
        return $this->render('classes/show.html.twig', [
            'class' => $class,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="classes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Classes $class): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');
        $form = $this->createForm(ClassesType::class, $class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('classes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('classes/edit.html.twig', [
            'class' => $class,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="classes_delete", methods={"POST"})
     */
    public function delete(Request $request, Classes $class): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');
        
        if ($this->isCsrfTokenValid('delete'.$class->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($class);
            $entityManager->flush();
        }

        return $this->redirectToRoute('classes_index', [], Response::HTTP_SEE_OTHER);
    }
}
