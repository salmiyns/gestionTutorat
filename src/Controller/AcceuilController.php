<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use App\Repository\PropositionRepository;
use App\Repository\RealisationRepository;
use App\Repository\SeanceRepository;
use App\Repository\UserRepository;
use DateTime;
use DoctrineExtensions\Query\Mysql\Date;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Transport\Smtp\Auth\AuthenticatorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AcceuilController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */

     
    public function index(UserRepository $userRepository, AuthorizationCheckerInterface $authorization,Request $request , CoursRepository $coursRepository ,SeanceRepository $seanceRepository , PropositionRepository $propositionRepository ,RealisationRepository $realisationRepository , PaginatorInterface $paginator): Response
    {
        //etudiant/index.html.twig
        //acceuil/index.html.twig
       // $cours= $coursRepository->findAll();
       /* if($this->getUser()){
            $user = getUser()->getEmail();
        }
        else{
            $user = "AnonymousUser";
        }*/


        $queryBuilder=$propositionRepository->findBy(['statut'=>'valide']);
        $totapropositions=count($queryBuilder);

         $propositions = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6/*limit per page*/
        );  
        
        
        if( $authorization->isGranted('ROLE_ENSEIGNANT') || $authorization->isGranted('ROLE_ADMIN') ){
            $queryBuilder=$propositionRepository->findBy(['statut'=>'valide']);
            $totapropositions=count($queryBuilder);
    
             $propositions = $paginator->paginate(
                $queryBuilder, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                6/*limit per page*/
            );  
            
           
        }

       
        
        $queryBuilder = $coursRepository->findAll();
        $totalCours= count($queryBuilder);
        $cours = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );  

        
        $realisations = count($realisationRepository->findAll());
        $seances = count($seanceRepository->findAll());


        $queryBuilder = $userRepository->findAll(); 
        $users = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6/*limit per page*/
        );     
        
        $queryBuilder=$seanceRepository->findBy_currentWeek();
        $seancesThisWeek = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );    
       
        $queryBuilder=$seanceRepository->findBy(['temps'=> new DateTime()]);
        $seancesToday = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );  

        
        //dd($seancesThisWeek);
        return $this->render('acceuil/index.html.twig', [
            'users' => $users  ,
            'propositions' =>$totapropositions,
            'cours' => $totalCours,
            'realisations' =>$realisations,
            'seancesThisWeek' => $seancesThisWeek,
            'seancesToday' => $seancesToday,
            'seances' => $seances,
            'listCours' => $cours ,
            //'listPropositions' => $propositions ,
            
            

            //'propositionsNonValid' => $propositionRepository->findByStatut('rejetée') ,
            //'propositionsValid' => $propositionRepository->findByStatut('valide'),
            //'propositionsEnAttent' => $propositionRepository->findByStatut('rejetée'),
            //'user' => $user,

            
        ]);
    }



}
