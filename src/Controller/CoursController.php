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
        $queryBuilder = $coursRepository->findAllBysearchTerm($q); 
        $list_cours = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );     
        


        //cours/index.html.twig
        
        return $this->render('cours/index1.html.twig', [
            'PageTitle'=>'Tous Les Cours',
            'cours' => $list_cours,
        ]);
    }

    /**
     * @Route("/new", name="cours_new", methods={"GET","POST"})
     */
    public function new(Request $request ,PropositionRepository $proposition,TuteurRepository $tuteurRepository,UploaderHelper $uploaderHelper): Response
    {
        $user = $this->getUser();

        
        $tuteur =  $tuteurRepository->findByConnectedUserId($user);


        //$listPropositions = $proposition->findPropositionByTuteurId($tuteur);
        
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
    public function show(Cours $cour): Response
    {
        
        return $this->render('cours/show.html.twig', [
            'cour' => $cour,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cours_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cours $cour , PropositionRepository $proposition,UploaderHelper $uploaderHelper): Response
    {
       
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
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cours_delete", methods={"DELETE"})
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
