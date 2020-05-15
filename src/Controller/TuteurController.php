<?php

namespace App\Controller;

use App\Entity\Tuteur;
use App\Form\TuteurType;
use App\Repository\TuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tuteur")
 */
class TuteurController extends AbstractController
{
    /**
     * @Route("/", name="tuteur_index", methods={"GET"})
     */
    public function index(TuteurRepository $tuteurRepository): Response
    {
        return $this->render('tuteur/index.html.twig', [
            'tuteurs' => $tuteurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tuteur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tuteur = new Tuteur();
        $form = $this->createForm(TuteurType::class, $tuteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tuteur);
            $entityManager->flush();

            return $this->redirectToRoute('tuteur_index');
        }

        return $this->render('tuteur/new.html.twig', [
            'tuteur' => $tuteur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tuteur_show", methods={"GET"})
     */
    public function show(Tuteur $tuteur): Response
    {
        return $this->render('tuteur/show.html.twig', [
            'tuteur' => $tuteur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tuteur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tuteur $tuteur): Response
    {
        $form = $this->createForm(TuteurType::class, $tuteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tuteur_index');
        }

        return $this->render('tuteur/edit.html.twig', [
            'tuteur' => $tuteur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tuteur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tuteur $tuteur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tuteur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tuteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tuteur_index');
    }
}
