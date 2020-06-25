<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Form\EnseignantType;
use App\Repository\EnseignantRepository;
use App\Repository\EtudiantRepository;
use App\Repository\PropositionRepository;
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
 * @Route("/enseignant")
 * @Security("is_granted('ROLE_ENSEIGNANT') ")
 * 
 */
class EnseignantController extends AbstractController
{
    /**
     * @Route("/", name="enseignant_index", methods={"GET"})
     */
    public function index(EnseignantRepository $enseignantRepository ,PropositionRepository $repository ,TuteurrRepository $tuteurRepository,Request $request,  PaginatorInterface $paginator): Response
    {

        $q = $request->query->get('q');
        $queryBuilder = $repository->getWithSearchQueryBuilder_withStatus('valide',$q); 
        
        $propositions = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            9/*limit per page*/
        );     



        return $this->render('enseignant/index.html.twig', [
            'propositions' => $enseignantRepository->findAll(),
        ]);
    }


        /**
     * @Route("/propositions", name="propositions_enseignant_index", methods={"GET"})
     */
    public function propositions_index(EnseignantRepository $enseignantRepository ,PropositionRepository $repository ,TuteurrRepository $tuteurRepository,Request $request,  PaginatorInterface $paginator): Response
    {

        $q = $request->query->get('q');
        $statut = $request->query->get('statut');
        if( !$statut == 'valide' || !$statut == 'reject' || !$statut == 'enAttente' ){
            $queryBuilder = $repository->getWithSearchQueryBuilder($q); 
           
        }
        else{
            $queryBuilder = $repository->getWithSearchQueryBuilder_withStatus($statut,$q); 
        }
        
        $propositions = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            9/*limit per page*/
        );     

        //dd($propositions);

        return $this->render('enseignant/proposiotions.index.html.twig', [
            'title' => $statut,
            'propositions' => $propositions,
        ]);
    }




        /**
     * @Route("/etudiants", name="etudiants", methods={"GET"})
     */
    public function ListEtudiant(EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="enseignant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $enseignant = new Enseignant();
        $form = $this->createForm(EnseignantType::class, $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($enseignant);
            $entityManager->flush();

            return $this->redirectToRoute('enseignant_index');
        }

        return $this->render('enseignant/new.html.twig', [
            'enseignant' => $enseignant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="enseignant_show", methods={"GET"})
     */
    public function show(Enseignant $enseignant): Response
    {
        return $this->render('enseignant/show.html.twig', [
            'enseignant' => $enseignant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="enseignant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Enseignant $enseignant): Response
    {
        $form = $this->createForm(EnseignantType::class, $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('enseignant_index');
        }

        return $this->render('enseignant/edit.html.twig', [
            'enseignant' => $enseignant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="enseignant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Enseignant $enseignant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enseignant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($enseignant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('enseignant_index');
    }
}
