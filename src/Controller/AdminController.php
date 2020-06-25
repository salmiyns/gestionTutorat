<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Entity\Etudiant;
use App\Entity\Proposition;
use App\Entity\Realisation;
use App\Entity\Seance;
use App\Entity\Tuteur;
use App\Entity\Tuteurr;
use App\Entity\Tutore;
use App\Entity\Tutoree;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\User1Type;
use App\Form\UserType;
use App\Repository\CoursRepository;
use App\Repository\EnseignantRepository;
use App\Repository\EtudiantRepository;
use App\Repository\PropositionRepository;
use App\Repository\RealisationRepository;
use App\Repository\SeanceRepository;
use App\Repository\TuteurrRepository;
use App\Repository\TutoreeRepository;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Security\LoginFormAuthenticator;
use DateTime;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Mailer\MailerInterface;
 use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
 
     /**
     * @Route("/", name="admin_homepage", methods={"GET"})
     */
    public function index(UserRepository $userRepository,PropositionRepository $propositionRepository,CoursRepository $coursRepository,RealisationRepository $realisationRepository , SeanceRepository $seanceRepository , PaginatorInterface $paginator, Request $request ): Response
    {

        $totapropositions = count($propositionRepository->findAll());
        $cours = count($coursRepository->findAll());
        $realisations = count($realisationRepository->findAll());
        $seances = count($seanceRepository->findAll());


        $queryBuilder = $userRepository->findAll(); 
        $users = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            8/*limit per page*/
        );     
        


        return $this->render('admin/dashborad.html.twig', [
            'users' => $users  ,
            'propositions' =>$totapropositions,
            'cours' => $cours,
            'realisations' =>$realisations,
            'seances' => $seances,

             
        ]);
    }



    /**
     * @Route("/users", name="admin_user_index", methods={"GET"})
     */
    public function userindex(UserRepository $userRepository ,Request $request, PaginatorInterface $paginator): Response
    {
        $q = $request->query->get('q');
        
        $queryBuilder = $userRepository->getWithSearchQueryBuilder2($q); 
        $users = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );          
       
        
        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
          
        ]);
    }

    

    /**
     * @Route("/users/new", name="admin_user_register_new")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator,MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        $random_password=substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 12 );

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $random_password
                )
            );



            $roles=array();
            $roles= $form->get('roles')->getData();

            $entityManager = $this->getDoctrine()->getManager();
            
            
            foreach($roles as $role)
            {
                if($role== 'ROLE_ENSEIGNANT'){
                    $enseignant = new Enseignant();
                    $enseignant->setIdUser($user);
                    $entityManager->persist($enseignant);
                     

                }
                elseif ($role== 'ROLE_TUTEUR' || $role == 'ROLE_TUTORE'){
                    
                    $etudiant = new Etudiant();
                    if($role == 'ROLE_TUTEUR' ){
                       // $tuteur=new Tuteur();
                        $tuteur=new Tuteurr();
                        $tuteur->setEtudiant($etudiant);
                        $entityManager->persist($tuteur);
                     }
                     else{
                        $tutore=new Tutore();
                        $tutore->setEtudiant($etudiant);
                        $entityManager->persist($tutore);
                     }

                     
                     $etudiant->setIdUser($user);
                     $entityManager->persist($etudiant);

                    

                }
               
            }
            //   génère un token et on l'enregistre
            $user->setActivationToken(md5(uniqid()));
            $user->setIsActive(false);
            $user->setVerified(false);

            


           
            $entityManager->persist($user);
            $entityManager->flush();

            // On crée le message
           $message =  (new TemplatedEmail())
           ->from(new Address('esallmiy@gmail.com', 'esallmiy@gmail.com'))
           ->to($user->getEmail())
           ->subject('Veuillez confirmer votre email')
           ->htmlTemplate('admin/emails/activation.html.twig')
           ->context([
                'token' => $user->getActivationToken(),
                'username' => $user->getEmail(),
                'password' => $random_password,
            ])
            ;



            
            $mailer->send($message);


            //dd($user->getActivationToken());


            /*return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );*/

            $this->addFlash('success', "l'utilisateur a été ajouté avec succès");
            return $this->redirectToRoute('admin_user_index');
       
        }

         return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]); 
        

    }
    /**
     * @Route("/users/{id}", name="admin_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/users/{id}/edit", name="admin_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user ,EtudiantRepository $etudiantRepository ,TutoreeRepository $tutoreRepository, EnseignantRepository $enseignantRepository,TuteurrRepository $tuteurrRepository): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUpdatedAt(new DateTime());


            $roles=array();
            $roles= $form->get('roles')->getData();

            $entityManager = $this->getDoctrine()->getManager();
            
            
            foreach($roles as $role)
            {
                if($role == 'ROLE_ENSEIGNANT'){
                    $enseignant= $enseignantRepository->findOneBy(['idUser'=>$user]);
                    if(!$enseignant){
                    $enseignant = new Enseignant();
                    $enseignant->setIdUser($user);
                    $entityManager->persist($enseignant);
                    }
                     

                }
                elseif ($role == 'ROLE_TUTEUR' || $role == 'ROLE_TUTORE'){

                    $etudiant= $etudiantRepository->findOneBy(['idUser'=>$user]);

                    if(!$etudiant){
                        $etudiant = new Etudiant();
                        $etudiant->setIdUser($user);
                        $entityManager->persist($etudiant);
                    }
                    else {

                        if($role == 'ROLE_TUTEUR' ){
                            //$tuteur=new Tuteur();
                            $tuteur= $tuteurrRepository->findOneBy(['etudiant'=>$etudiant]);
                            
                            if(!$tuteur){
                                $tuteur= new Tuteurr();
                                $tuteur->setEtudiant($etudiant);
                                $entityManager->persist($tuteur);
                            }
                           
                         }
                         else{
                            $tutore= $tutoreRepository->findOneBy(['etudiant'=>$etudiant]);
                            //dd($tutore);
                            if(is_null($tutore)){
                            $tutore=new Tutoree();
                            $tutore->setEtudiant($etudiant);
                            $entityManager->persist($tutore);
                            }
                         }
                        
                    }

                    
                    


                     
                     
                     


                    

                    

                }
               
            }

            if  (empty($user->getCreatedAt())){

                $user->setCreatedAt(new DateTime());

            }
           
            $entityManager->flush();


            $this->addFlash('success', "l'utilisateur a été Modifier avec succès");
            return $this->redirectToRoute('admin_user_index');


            

         }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="admin_user_delete",  methods={"GET","POST"})
     */
    public function delete(Request $request, User $user,CsrfTokenManagerInterface $csrfTokenManager): Response
    {

       /* $token = new CsrfToken('delete', $request->query->get('_csrf_token'));

        if (!$csrfTokenManager->isTokenValid($token)) {
            throw $this->createAccessDeniedException('Token CSRF invalide');
        }
        
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }*/



        



        if ($user) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }


        $this->addFlash('success', "l'utilisateur a été Suprimer avec succès");
 
  
         

        return $this->redirectToRoute('admin_user_index');
    }




    
}
