<?php

namespace App\Controller;

use App\Entity\Proposition;
use App\Entity\Realisation;
use App\Entity\Tuteur;
use App\Form\RealisationType;
use App\Repository\PropositionRepository;
use App\Repository\RealisationRepository;
use App\Repository\TuteurRepository;
use App\Repository\TuteurrRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/realisation")
 */
class RealisationController extends AbstractController
{
    /**
     * @Route("/", name="realisation_index", methods={"GET"})
     * 
     */
    public function index(RealisationRepository $realisationRepository ,Request $request,PaginatorInterface $paginator): Response
    {
        $user = $this->getUser()->getId();
        
        
         
        $queryBuilder = $realisationRepository->findByidUser($user); 
        $queryBuilder_RealisationsOf_currentWeek = $realisationRepository->findByidUser_currentWeek($user); 

    
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
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUTEUR') ")
     */
    public function new(Request $request , TuteurrRepository $tuteurRepository ,PropositionRepository $propositionRepository ): Response
    {
        $user = $this->getUser();
       
        
         $realisation = new Realisation();

         $etudiant=$user->getEtudiant();
         if(is_null($etudiant)){
            
            $this->addFlash('error', "ce compte etudiant n'existe pas au base donnee");
            return $this->redirectToRoute('realisation_index');
         }

         $tuteur =$etudiant->getTuteurr();

         if(is_null($tuteur)){
           
            $this->addFlash('error', "ce compte Tuteur n'existe pas au base donnee");
            return $this->redirectToRoute('realisation_index');
         }

         
         //$tuteur = $tuteurRepository->findByConnectedUserId($user);

        $form = $this->createForm(RealisationType::class, $realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $realisation->setDateCreation(new \DateTime());
            $realisation->setDateModification(new \DateTime());
            $realisation->setTuteur($tuteur);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($realisation);
            $entityManager->flush();
            $this->addFlash('success', "la Realisation  a été Ajouter avec succès");
            return $this->redirectToRoute('realisation_index');
        }

        return $this->render('realisation/new.html.twig', [
            'realisation' => $realisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="realisation_show", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUTEUR') ")
     */
    public function show(Realisation $realisation,  Request $request): Response
    {

        if(!$realisation){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Cette Proposition n\'existe pas');
        }

        
        $tuteur=  $realisation->getTuteur();
        if(!$tuteur){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Cette Proposition n\'a pas un tuteur');
        }
        $etudiant=$tuteur->getEtudiant();
        $user=$etudiant->getIdUser();
        //$Listcours=$realisation->getCours();


         
        return $this->render('realisation/show.html.twig', [
            'realisation' => $realisation,
            
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="realisation_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUTEUR') ")
     */
    public function edit(Request $request, Realisation $realisation): Response
    {
        if(!$realisation){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Cette Proposition n\'existe pas');
        }

        
        $tuteur=  $realisation->getTuteur();
        if(!$tuteur){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Cette Proposition n\'a pas un tuteur');
        }
        $etudiant=$tuteur->getEtudiant();
        $user=$etudiant->getIdUser();
 


        $form = $this->createForm(RealisationType::class, $realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', "la Realisation  a été Modifier avec succès");
            return $this->redirectToRoute('realisation_index');
        }


        return $this->render('realisation/edit.html.twig', [
            'realisation' => $realisation,
            'user'=>$user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="realisation_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUTEUR') ")
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
