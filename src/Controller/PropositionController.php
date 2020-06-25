<?php

namespace App\Controller;

use App\Entity\Proposition;
use App\Entity\Realisation;
use App\Entity\Tuteur;
use App\Form\PropositionType;
use App\Repository\EtudiantRepository;
use App\Repository\PropositionRepository;
use App\Repository\RealisationRepository;
use App\Repository\TuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use PhpParser\Node\Expr\Cast\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TuteurrRepository;
use Symfony\Component\Validator\Constraints\IsNull;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/proposition")
 */
class PropositionController extends AbstractController
{
    /**
     * @Route("/", name="proposition_index", methods={"GET","POST"})
     * 
     */
    public function index(PropositionRepository $repository ,TuteurRepository $tuteurRepository,Request $request,  PaginatorInterface $paginator ,AuthorizationCheckerInterface $authorization): Response
    {

       $user = $this->getUser();
       $statut=$request->query->get('statut');
       $q = $request->query->get('q');
       //$auth = 'Bad';
      // dd($statut);

       if( !$statut == 'validee' || !$statut == 'reject' || !$statut == 'enAttente'  && !$authorization->isGranted('TUTEUR')){
            $statut="valide";
           
        } 
        
 
  
       // dd($auth);
               
        //dd($user);
       
        $queryBuilder = $repository->getWithSearchQueryBuilder_withStatus($statut,$q); 
        $propositions = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            9/*limit per page*/
        );     
        
        $proposition = new Proposition();

        
        $tuteur =  $tuteurRepository->findByUserId($user);

        $form = $this->createForm(PropositionType::class, $proposition);
        if (empty($tuteur)  ) { 
            $form->addError(new FormError('Aucun compte tuteur pour cet utilisateur , pour ajouter une proposition, vous devez avoir un compte avec un rôle de tuteur'));
        }

        

        $form->handleRequest($request);

 
        if ($form->isSubmitted() && $form->isValid()) {
            $proposition->setDateCreation(new \DateTime());
            $proposition->setDateModification(new \DateTime());
            $proposition->setStatut('valide');
            $proposition->setTuteur($tuteur[0]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($proposition);
            $entityManager->flush();

            return $this->redirectToRoute('proposition_index');
        }
        
        return $this->render('proposition/index.html.twig', [
            'title' => 'Tous',
            'propositions' => $propositions,
            'form' => $form->createView(),
            //'propositionVaidees' => $propositionByStatus,
            //'propositionByStatut' => $propositionByStatus,
        ]); 
    }

    /**
     * @Route("/new", name="proposition_new", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUTEUR') ")
     */
    public function new(Request $request,TuteurrRepository $tuteurRepository,EtudiantRepository $etudiantRepository): Response
    {
         
         
        $proposition = new Proposition();
        $user = $this->getUser();


        //$etudiant=$etudiantRepository->findOneBy(['idUser'=> $user ]);
        $etudiant=$user->getEtudiant();
        if(!($etudiant)){
            return $this->redirectToRoute('proposition_index');
            $this->addFlash('error', "ce compte etudiant n'existe pas au base donnee");
         }

        
        
        
        
        $form = $this->createForm(PropositionType::class, $proposition);
        

        $form->handleRequest($request);
        
        
       // $tuteur =$tuteurRepository->findAll();
        //$tuteur =$tuteurRepository->findOneBy(['id'=>$tuteurs[0]['id']]);
        //$etudiantId=$etudiant->getId();
        //$tuteur = $tuteurRepository->findOneBy(['etudiant'=> $etudiantId]);
        $tuteur = $etudiant->getTuteurr();
        if(!($tuteur)){
            return $this->redirectToRoute('proposition_index');
            $this->addFlash('error', "ce compte Tuteur n'existe pas au base donnee");
         }

 

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $proposition->setDateCreation(new \DateTime());
                $proposition->setDateModification(new \DateTime());
                $proposition->setTuteurr($tuteur);
    
                $proposition->setStatut('enAttente');
                $entityManager->persist($proposition);
                $entityManager->flush();
                $this->addFlash('success', "la Proposition a été Ajouter avec succès");
                return $this->redirectToRoute('proposition_index');
            }

       
        
        

        
        return $this->render('proposition/new.html.twig', [
            'proposition' => $proposition,
            'form' => $form->createView(),
        ]);   
    }

    /**
     * @Route("/{id}", name="proposition_show", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUTEUR') or is_granted('ROLE_ENSEIGNANT')")
     */
    public function show(Proposition $proposition,PaginatorInterface $paginator ,Request $request): Response
    {
        if(!$proposition){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Cette Proposition n\'existe pas');
        }

        
        $tuteur=  $proposition->getTuteurr();
        if(!$tuteur){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Cette Proposition n\'a pas un tuteur');
        }
        $etudiant=$tuteur->getEtudiant();
        $user=$etudiant->getIdUser();
        $Listcours=$proposition->getCours();


        $cours = $paginator->paginate(
            $Listcours, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        ); 
        //dd($Listcours);
        return $this->render('proposition/show.html.twig', [
            'proposition' => $proposition,
            'user' => $user,
            'cours' => $cours,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="proposition_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUTEUR') ")
     */
    public function edit(Request $request, Proposition $proposition  ): Response
    {
        $this->denyAccessUnlessGranted('ROLE_TUTEUR');

       
        $form = $this->createForm(PropositionType::class, $proposition);

        /*
        $realisation=$product = $this->getDoctrine()
        ->getRepository(Realisation::class)
        ->find($proposition);*/
        if(!$proposition){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Cette Proposition n\'existe pas');
        }

        
        $tuteur=  $proposition->getTuteurr();
        if(!$tuteur){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Cette Proposition n\'a pas un tuteur');
        }
        $etudiant=$tuteur->getEtudiant();
        $user=$etudiant->getIdUser();
        //dd($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('proposition_index');
        }

        return $this->render('proposition/edit.html.twig', [
            'proposition' => $proposition,
            'user'=> $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="proposition_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUTEUR')")
     */
    public function delete(Request $request, Proposition $proposition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$proposition->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($proposition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('proposition_index');
    }




     /**
      *  
     * @Route("/validee/{id}", name="ensignant_proposition_validee",  methods={"GET","POST"})
     * @Security("is_granted('ROLE_ENSEIGNANT')")
     */
    public function validee(Request $request, Proposition $proposition): Response
    {
 
        

    
        if ($proposition) {
            $proposition->setStatut('valide');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($proposition);
            $entityManager->flush();
            $this->addFlash('success', "la Propostion  a été validee avec succès");
        }
        else{
            $this->addFlash('success', "cette proposition n'existe pas au base donnee");
        }


       
 
  
         

        return $this->redirectToRoute('propositions_enseignant_index');
    }




     /**
     * @Route("/reject/{id}", name="ensignant_proposition_reject",  methods={"GET","POST"})
     * @Security("is_granted('ROLE_ENSEIGNANT')  ")
     */
    public function reject(Request $request, Proposition $proposition): Response
    {
 
        
        

        if ($proposition) {
            $proposition->setStatut('reject');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($proposition);
            $entityManager->flush();
            $this->addFlash('success', "la Propostion  a été Modifier avec succès");
        }
        else{
            $this->addFlash('success', "cette proposition n'existe pas au base donnee");
        }

 
  
         

        return $this->redirectToRoute('propositions_enseignant_index');
    }
}
