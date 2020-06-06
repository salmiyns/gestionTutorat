<?php

namespace App\Controller;

use App\Entity\Proposition;
use App\Entity\Realisation;
use App\Entity\Tuteur;
use App\Form\RealisationType;
use App\Repository\PropositionRepository;
use App\Repository\RealisationRepository;
use App\Repository\TuteurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/realisation")
 */
class RealisationController extends AbstractController
{
    /**
     * @Route("/", name="realisation_index", methods={"GET"})
     */
    public function index(RealisationRepository $realisationRepository ,Request $request,PaginatorInterface $paginator): Response
    {
        $user = $this->getUser()->getId();
        
        
         
        $queryBuilder = $realisationRepository->findByUserId($user); 
        $queryBuilder_RealisationsOf_currentWeek = $realisationRepository->findByUserId_currentWeek($user); 

    
        //dd($queryBuilder_RealisationsOf_currentWeek);


        $realisation = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );    
        
        

        $currentWeekRealisation = $paginator->paginate(
            $queryBuilder_RealisationsOf_currentWeek, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );  

        return $this->render('realisation/index.html.twig', [
            'realisations' => $realisation,
            'currentWeekRealisation' => $currentWeekRealisation,
        ]);
    }

    /**
     * @Route("/new", name="realisation_new", methods={"GET","POST"})
     */
    public function new(Request $request , TuteurRepository $tuteurRepository ,PropositionRepository $propositionRepository ): Response
    {
        $user = $this->getUser();
       
        
         $realisation = new Realisation();

         $tuteur = $tuteurRepository->findByConnectedUserId($user);

        $form = $this->createForm(RealisationType::class, $realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $realisation->setDateCreation(new \DateTime());
            $realisation->setDateModification(new \DateTime());
            $realisation->setTuteur($tuteur[0]);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($realisation);
            $entityManager->flush();

            return $this->redirectToRoute('realisation_index');
        }

        return $this->render('realisation/new.html.twig', [
            'realisation' => $realisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="realisation_show", methods={"GET"})
     */
    public function show(Realisation $realisation): Response
    {
        return $this->render('realisation/show.html.twig', [
            'realisation' => $realisation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="realisation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Realisation $realisation): Response
    {
        $form = $this->createForm(RealisationType::class, $realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('realisation_index');
        }

        return $this->render('realisation/edit.html.twig', [
            'realisation' => $realisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="realisation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Realisation $realisation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$realisation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($realisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('realisation_index');
    }
}
