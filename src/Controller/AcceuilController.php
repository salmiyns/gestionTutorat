<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use App\Repository\PropositionRepository;
use App\Repository\SeanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class AcceuilController extends AbstractController
{
    /**
     * @Route("/dashboord_etudiant", name="dashboord_etudiant")
     */

     
    public function index(CoursRepository $coursRepository ,SeanceRepository $seanceRepository , PropositionRepository $propositionRepository  ): Response
    {
        //etudiant/index.html.twig
        //acceuil/index.html.twig
        $cours= $coursRepository->findAll();
       /* if($this->getUser()){
            $user = getUser()->getEmail();
        }
        else{
            $user = "AnonymousUser";
        }*/
        

        return $this->render('demo9.base.html.twig', [
            'cours' =>  $cours,
            'propositionsNonValid' => $propositionRepository->findByStatut('rejetée') ,
            'propositionsValid' => $propositionRepository->findByStatut('valide'),
            'propositionsEnAttent' => $propositionRepository->findByStatut('rejetée'),
            //'user' => $user,

            
        ]);
    }



}
