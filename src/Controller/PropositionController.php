<?php

namespace App\Controller;

use App\Entity\Proposition;
use App\Form\PropositionType;
use App\Repository\PropositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proposition")
 */
class PropositionController extends AbstractController
{
    /**
     * @Route("/", name="proposition_index", methods={"GET"})
     */
    public function index(PropositionRepository $repository ,Request $request,  PaginatorInterface $paginator): Response
    {

       // $user = $this->getUser();
        //,$user->getId()

        

    $q = $request->query->get('q');

        $queryBuilder = $repository->getWithSearchQueryBuilder($q);
        $queryBuilder1 =$repository->findOnlyByStatut('valide');

        $propositions = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );  

        $propositionByStatus = $paginator->paginate(
            $queryBuilder1, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );  

        

        
        return $this->render('proposition/index.html.twig', [
            'propositions' => $propositions,
            //'propositionVaidees' => $propositionByStatus,
            //'propositionByStatut' => $propositionByStatus,
        ]); 
    }



        /**
     * @Route("/status", name="pStatus_index", methods={"GET"})
     */
    public function indexbySatut(PropositionRepository $repository): Response
    {
        $seances = $repository->findByStatut('valide');
        dd($seances);
        
    }



    /**
     * @Route("/new", name="proposition_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $proposition = new Proposition();
        $form = $this->createForm(PropositionType::class, $proposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
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
