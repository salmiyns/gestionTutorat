<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Proposition;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use App\Repository\PropositionRepository;
use App\Repository\TuteurRepository;
use App\Service\UploaderHelper;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



/**
 * @Route("/cours")
 */
class CoursController extends AbstractController
{
    /**
     * @Route("/", name="cours_index", methods={"GET"})
     */
    public function index(CoursRepository $coursRepository ,Request $request ,PaginatorInterface $paginator): Response
    {
        $q = $request->query->get('q');
        $pps=$request->query->get('pps');

       // dd($index) ;

        /*
        return $this->render('cours/index.all.html.twig', [
            'PageTitle'=>'Tous Les Cours',
            //'cours' => $list_cours,
             
        ]);*/
        $queryBuilder = $coursRepository->findAllBysearchTerm($q); 
        $list_cours = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6/*limit per page*/
        );  


         
        $queryBuilder = $coursRepository->findBy([], ['id' => 'DESC']); 
        $list_cours_DESC = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6/*limit per page*/
        );  


        
 
        


        //cours/index.html.twig
        //https://127.0.0.1:8000/cours/?index=all
        if(!$pps){
            $list_cours_DESC = $paginator->paginate(
                $queryBuilder, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                6/*limit per page*/
            );  
            return $this->render('cours/index.all.html.twig', [
                'PageTitle'=>'Tous Les Cours',
                'cours' => $list_cours_DESC,
                 
            ]);
        }else{
            $queryBuilder = $coursRepository->findBy(['proposition'=> $pps ], ['id' => 'DESC']); 

            $list_cours_DESC = $paginator->paginate(
                $queryBuilder, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                6/*limit per page*/
            );  
            return $this->render('cours/index.all.html.twig', [
                'PageTitle'=>'Tous Les Cours',
                'cours' => $list_cours_DESC,
                 
            ]);

        }
        
        return $this->render('cours/index1.html.twig', [
            'PageTitle'=>'Tous Les Cours',
            'cours' => $list_cours,
            'coursDesc' => $list_cours_DESC,
        ]);
    }

    /**
     * @Route("/new", name="cours_new", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUTEUR') ")
     */
    public function new(Request $request ,PropositionRepository $proposition,TuteurRepository $tuteurRepository,UploaderHelper $uploaderHelper): Response
    {
        $user = $this->getUser();

        
        //$tuteur =  $tuteurRepository->findByConnectedUserId($user);


        //$listPropositions = $proposition->findPropositionByTuteurId($tuteur);
        

        $etudiant=$user->getEtudiant();
        if(is_null($etudiant)){
           return $this->redirectToRoute('realisation_index');
           $this->addFlash('error', "ce compte etudiant n'existe pas au base donnee");
        }

        $tuteur =$etudiant->getTuteurr();

        if(is_null($tuteur)){
           return $this->redirectToRoute('realisation_index');
           $this->addFlash('error', "ce compte Tuteur n'existe pas au base donnee");
        }
        $propositions=$tuteur->getPropositions();
        //dd($propositions);
        $cour = new Cours();
        $cour->setDateCreation(new \DateTime());
        $cour->setDernierModification(new \DateTime());
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['image']->getData();
            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadCoursImage($uploadedFile, $cour->getImage());
                $cour->setImage($newFilename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($cour);
            $entityManager->flush();

            return $this->redirectToRoute('cours_index');
        }

        return $this->render('cours/new.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cours_show", methods={"GET"})
     */
    public function show(Cours $cour ,PaginatorInterface $paginator, Request $request): Response
    {
        if(!$cour){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('ce cours n\'existe pas');
        }

        $proposition=$cour->getProposition();

        if(!$proposition){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Cette Proposition n\'existe pas');
        }
        $tuteur=$proposition->getTuteurr();
        $listRealisation=$cour->getRealisations();
        //dd($tuteur);
        //$tuteur=  $realisation->getTuteur();
        if(!$tuteur){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Tuteur Introuvable');
        }
        $etudiant=$tuteur->getEtudiant();
        $user=$etudiant->getIdUser();
        

        $realisations = $paginator->paginate(
            $listRealisation, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        ); 
        return $this->render('cours/show.html.twig', [
            'cour' => $cour,
            'user'=>$user,
            'realisations'=>$realisations,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cours_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUTEUR') ")
     */
    public function edit(Request $request, Cours $cour ,UploaderHelper $uploaderHelper): Response
    {
        if(!$cour){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('ce cours n\'existe pas');
        }

        $proposition=$cour->getProposition();

        if(!$proposition){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Cette Proposition n\'existe pas');
        }
        $tuteur=$proposition->getTuteurr();
        //dd($tuteur);
        //$tuteur=  $realisation->getTuteur();
        if(!$tuteur){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Tuteur Introuvable');
        }
        $etudiant=$tuteur->getEtudiant();
        $user=$etudiant->getIdUser();
       
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);
       
       
        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['image']->getData();
            if ($uploadedFile) {
                $newFilename = $uploaderHelper->uploadCoursImage($uploadedFile, $cour->getImage());
                $cour->setImage($newFilename);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cours_index');
        }

        return $this->render('cours/edit.html.twig', [
            'cour' => $cour,
            'user'=>$user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cours_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUTEUR') ")
     */
    public function delete(Request $request, Cours $cour): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cours_index');
    }



     
    }
