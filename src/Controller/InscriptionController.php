<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Realisation;
use App\Form\InscriptionType;
use App\Repository\EtudiantRepository;
use App\Repository\InscriptionRepository;
use App\Repository\TuteurrRepository;
use App\Repository\TutoreeRepository;
use App\Repository\TutoreRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\IsNull;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



/**
 * @Route("/inscription")
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUTEUR') or is_granted('ROLE_TUTORE') ")
 * 
 */
class InscriptionController extends AbstractController
{
    /**
     * @Route("/", name="inscription_index", methods={"GET"})
     */
    public function index(Request $request, InscriptionRepository $inscriptionRepository ,EtudiantRepository $etudiantRepository,TutoreeRepository $tutoreeRepository ,TuteurrRepository $tuteurrRepository ,PaginatorInterface $paginator): Response
    {
        $user = $this->getUser();
        $statut=$request->query->get('statut');
        if( !$statut == 1 || !$statut == 2 || !$statut == 3){
             $statut=1;
            
         } 
        
 
        $etudiant= $etudiantRepository->findOneBy(['idUser'=>$user]);

         //$user->getEtudiant();
         if(!$etudiant){
            
            $this->addFlash('error', "ce compte etudiant n'existe pas au base donnee");
            return $this->redirectToRoute('inscription_index');
         }

         $tutore= $tutoreeRepository->findOneBy(['etudiant'=>$etudiant]);
         $tuteur= $etudiant->getTuteurr();
        // dd($tuteur);

         if(!$tutore &&  !$tuteur){
           
            $this->addFlash('error', "ce compte Etudiant Tuteur ou Tutoré n'existe pas au base donnee");
            return $this->redirectToRoute('inscription_index');
         }
         else {

            if($tutore){
                $queryBuilder =  $inscriptionRepository->findByTutoreAndStatut( $tutore ,$statut);
            }
            else {
                $queryBuilder =  $inscriptionRepository->findByTuteurAndStatut($tuteur ,$statut); ;
            }


         }


         //dd($queryBuilder);
         
         $inscriptions = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );     
        
         //dd($inscriptions);
        return $this->render('inscription/index.html.twig', [
            'inscriptions' => $inscriptions ,
        ]);
    }

    /**
     * @Route("/new", name="inscription_new", methods={"GET","POST"})
     */
    public function new(Request $request ,EtudiantRepository $etudiantRepository , TutoreeRepository $tutoreeRepository): Response
    {
        $inscription = new Inscription();
        $user = $this->getUser();
       
        
 
        $etudiant= $etudiantRepository->findOneBy(['idUser'=>$user]);

         //$user->getEtudiant();
         if(is_null($etudiant)){
            
            $this->addFlash('error', "ce compte etudiant n'existe pas au base donnee");
            return $this->redirectToRoute('inscription_index');
         }

         $tutore= $tutoreeRepository->findOneBy(['etudiant'=>$etudiant]);


         if(is_null($tutore)){
           
            $this->addFlash('error', "ce compte Tutoré n'existe pas au base donnee");
            return $this->redirectToRoute('inscription_index');
         }





        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $inscription->setTutore($tutore);
            $inscription->setDateInscrption(new \DateTime());
            $inscription->setStatut(3);
            $entityManager->persist($inscription);
            $entityManager->flush();

            return $this->redirectToRoute('inscription_index');
        }

        return $this->render('inscription/new.html.twig', [
            'inscription' => $inscription,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="inscription_show", methods={"GET"})
     */
    public function show(Inscription $inscription): Response
    {
        return $this->render('inscription/show.html.twig', [
            'inscription' => $inscription,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="inscription_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Inscription $inscription): Response
    {
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('inscription_index');
        }

        return $this->render('inscription/edit.html.twig', [
            'inscription' => $inscription,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="inscription_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Inscription $inscription): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inscription->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($inscription);
            $entityManager->flush();
        }

        return $this->redirectToRoute('inscription_index');
    }



    /**
     * @Route("valider/{id}", name="inscription_valider", methods={"GET","POST"})
     */
    public function valider(Request $request, Inscription $inscription): Response
    {
        if ($inscription) {
            $inscription->setStatut(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inscription);
            $entityManager->flush();
            $this->addFlash('success', "l Inscription  a été Modifier avec succès");
        }
        else{
            $this->addFlash('error', "cette Inscription n'existe pas au base donnee");
        }

 
  
         

        return $this->redirectToRoute('inscription_index');
    
    }


    /**
     * @Route("refuse/{id}", name="inscription_refuse", methods={"GET","POST"})
     */
    public function refuse(Request $request, Inscription $inscription): Response
    {
        if ($inscription) {
            $inscription->setStatut(2);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($inscription);
            $entityManager->flush();
            $this->addFlash('success', "l Inscription  a été Modifier avec succès");
        }
        else{
            $this->addFlash('error', "cette Inscription n'existe pas au base donnee");
        }

 
  
         

        return $this->redirectToRoute('inscription_index');
    
    }


    
}
