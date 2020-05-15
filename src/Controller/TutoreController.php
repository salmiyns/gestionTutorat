<?php

namespace App\Controller;

use App\Entity\Tutore;
use App\Form\TutoreType;
use App\Repository\TutoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tutore")
 */
class TutoreController extends AbstractController
{
    /**
     * @Route("/", name="tutore_index", methods={"GET"})
     */
    public function index(TutoreRepository $tutoreRepository): Response
    {
        return $this->render('tutore/index.html.twig', [
            'tutores' => $tutoreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tutore_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tutore = new Tutore();
        $form = $this->createForm(TutoreType::class, $tutore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tutore);
            $entityManager->flush();

            return $this->redirectToRoute('tutore_index');
        }

        return $this->render('tutore/new.html.twig', [
            'tutore' => $tutore,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tutore_show", methods={"GET"})
     */
    public function show(Tutore $tutore): Response
    {
        return $this->render('tutore/show.html.twig', [
            'tutore' => $tutore,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tutore_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tutore $tutore): Response
    {
        $form = $this->createForm(TutoreType::class, $tutore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tutore_index');
        }

        return $this->render('tutore/edit.html.twig', [
            'tutore' => $tutore,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tutore_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tutore $tutore): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tutore->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tutore);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tutore_index');
    }
}
