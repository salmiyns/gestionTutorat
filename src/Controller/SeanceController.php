<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Form\SeanceType;
use App\Repository\SeanceRepository;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
 * @Route("/seance")
 * 
 */
class SeanceController extends AbstractController
{
    /**
     * @Route("/", name="seance_index", methods={"GET"})
     * 
     */
    public function index(SeanceRepository $seanceRepository,Request $request ,PaginatorInterface $paginator): Response
    {
        $q = $request->query->get('q');
        $date=$request->query->get('date');
        if ($date == 'today' || $date == 'week' ){
            if ($date == 'today'){ 
                $queryBuilder = $seanceRepository->findBy(['temps'=> new DateTime() ], ['id' => 'DESC']); 
            }
            else{
                $queryBuilder=$seanceRepository->findBy_currentWeek();
       
            }
        }
        else {
            $queryBuilder=$seanceRepository->findAll();
        }
        
        $list_Seances = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );     
        



        return $this->render('seance/index.html.twig', [
            'seances' => $list_Seances,
        ]);
    }

    /**
     * @Route("/new", name="seance_new", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUTEUR') ")
     */
    public function new(Request $request): Response
    {
        $seance = new Seance();
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($seance);
            $entityManager->flush();

            return $this->redirectToRoute('seance_index');
        }

        return $this->render('seance/new.html.twig', [
            'seance' => $seance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="seance_show", methods={"GET"})
     */
    public function show(Seance $seance): Response
    {
        return $this->render('seance/show.html.twig', [
            'seance' => $seance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="seance_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUTEUR') ")
     */
    public function edit(Request $request, Seance $seance): Response
    {
        $form = $this->createForm(SeanceType::class, $seance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('seance_index');
        }

        return $this->render('seance/edit.html.twig', [
            'seance' => $seance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="seance_delete", methods={"DELETE"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TUTEUR') ")
     */
    public function delete(Request $request, Seance $seance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($seance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('seance_index');
    }
}
