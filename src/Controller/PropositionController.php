<?php

namespace App\Controller;

use App\Entity\Proposition;
use App\Entity\Tuteur;
use App\Form\PropositionType;
use App\Repository\PropositionRepository;
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

/**
 * @Route("/proposition")
 */
class PropositionController extends AbstractController
{
    /**
     * @Route("/", name="proposition_index", methods={"GET","POST"})
     */
    public function index(PropositionRepository $repository ,TuteurRepository $tuteurRepository,Request $request,  PaginatorInterface $paginator): Response
    {

       $user = $this->getUser();
               
        //dd($user);
        $q = $request->query->get('q');
        $queryBuilder = $repository->getWithSearchQueryBuilder_withStatus('valide',$q); 
        $propositions = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );     
        
        $proposition = new Proposition();

        
        $tuteur =  $tuteurRepository->findByConnectedUserId($user);

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
     * @Route("/validee", name="proposition_validee", methods={"GET"})
     */
    public function index_pValide(PropositionRepository $repository ,Request $request,  PaginatorInterface $paginator): Response
    {

        $user = $this->getUser()->getId();
        
        
        $q = $request->query->get('q');
        
        $queryBuilder = $repository->getByUserWithSearchQueryBuilder_withStatus($user,'valide',$q); 
        $propositions = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );          
        return $this->render('proposition/index.html.twig', [
            'title' => 'Votre propositions Validee ',
            'propositions' => $propositions,
            //'propositionVaidees' => $propositionByStatus,
            //'propositionByStatut' => $propositionByStatus,
        ]); 
    }

/**
     * @Route("/Rajetee", name="proposition_Rajetee", methods={"GET"})
     */
    public function index_pRajetee(PropositionRepository $repository ,Request $request,  PaginatorInterface $paginator): Response
    {

        $user = $this->getUser()->getId();
        
        
        $q = $request->query->get('q');
        
        $queryBuilder = $repository->getByUserWithSearchQueryBuilder_withStatus($user,'rajetee',$q); 
        $propositions = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );          
        return $this->render('proposition/index.html.twig', [
            'title' => 'Votre propositions Validee ',
            'propositions' => $propositions,
            //'propositionVaidees' => $propositionByStatus,
            //'propositionByStatut' => $propositionByStatus,
        ]); 
    }

    
    /**
     * @Route("/enAttente", name="proposition_Rajetee", methods={"GET"})
     */
    public function index_penAttente(PropositionRepository $repository ,Request $request,  PaginatorInterface $paginator): Response
    {

        $user = $this->getUser()->getId();
        
        
        $q = $request->query->get('q');
        
        $queryBuilder = $repository->getByUserWithSearchQueryBuilder_withStatus($user,'en attente',$q); 
        $propositions = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );          
        return $this->render('proposition/index.html.twig', [
            'title' => 'Votre propositions Validee ',
            'propositions' => $propositions,
            //'propositionVaidees' => $propositionByStatus,
            //'propositionByStatut' => $propositionByStatus,
        ]); 
    }

       
    /**
     * @Route("/tuuur", name="tuuur", methods={"GET"})
     */
    public function index_tuuurpenAttente(TuteurRepository $repository ,Request $request,  PaginatorInterface $paginator): Response
    {

        $user = $this->getUser()->getId();
        
        
        $q = $request->query->get('q');
        
        $queryBuilder = $repository->findByConnectedUserId($user); 
        $propositions = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );          
       
        dd($$propositions->id);
    }
    /**
     * @Route("/new", name="proposition_new", methods={"GET","POST"})
     */
    public function new(Request $request,TuteurRepository $tuteurRepository): Response
    {
        $this->denyAccessUnlessGranted(new Expression(
            '"ROLE_TUTEUR" in role_names or (not is_anonymous() and user.isSuperAdmin())'
        ));
         
        $user = $this->getUser();
        $proposition = new Proposition();
       
        
        $form = $this->createForm(PropositionType::class, $proposition);
        

        $form->handleRequest($request);
        
        
        $tuteur =  $tuteurRepository->findByConnectedUserId($user);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $proposition->setDateCreation(new \DateTime());
            $proposition->setDateModification(new \DateTime());
            $proposition->setTuteur($tuteur[0]);

            $proposition->setStatut('valide');
            $entityManager->persist($proposition);
            $entityManager->flush();
 
            return $this->redirectToRoute('proposition_index');
        }
        

        
        return $this->render('proposition/new.html.twig', [
            'proposition' => $proposition,
            'form' => $form->createView(),
        ]);   
    }

    /**
     * @Route("/{id}", name="proposition_show", methods={"GET"})
     */
    public function show(Proposition $proposition): Response
    {
        return $this->render('proposition/show.html.twig', [
            'proposition' => $proposition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="proposition_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Proposition $proposition): Response
    {
       
        $form = $this->createForm(PropositionType::class, $proposition);

        
        


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('proposition_index');
        }

        return $this->render('proposition/edit.html.twig', [
            'proposition' => $proposition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="proposition_delete", methods={"DELETE"})
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
}
