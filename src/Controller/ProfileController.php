<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use App\Form\ProfileType;
use App\Form\EtudiantType;
use App\Form\EnsignantType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Etudiant;
use App\Repository\EtudiantRepository;
use App\Repository\EnseignantRepository;




/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="user_profile")
     */
    public function index( Request $request ): Response
    {

    
        $user = $this->getUser();
        
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUpdatedAt(new DateTime());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('message', 'Modification a été enregistré avec succès');

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);



        
    }


       /**
     * @Route("/student_info", name="student_info")
     */
    public function student_info( Request $request , EtudiantRepository $etudiantRepository ): Response
    {

    
        $user = $this->getUser();
        $etudiant = $etudiantRepository->findOneBy(['idUser' => $user]);
        
           // Si aucun utilisateur n'est associé à ce token
           if(!$etudiant){
               // On renvoie une erreur 404
               throw $this->createNotFoundException('Cet etudiant n\'existe pas');
           }
        
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             $this->getDoctrine()->getManager()->flush();
            $this->addFlash('message', 'Modification a été enregistré avec succès');

            return $this->redirectToRoute('student_info');
        }

        return $this->render('profile/student_info/edit_student_info.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);



        
    }
  



           /**
     * @Route("/ensignant_info", name="ensignant_info")
     */
    public function ensignant_info( Request $request , EnseignantRepository $enseignantRepository ): Response
    {

    
        $user = $this->getUser();
        $ensignant = $enseignantRepository->findOneBy(['idUser' => $user]);
        
            if(!$ensignant){
                $this->addFlash(
                    'error',
                    'Cet ensignant n\'existe pas'
                );
                //$this->addFlash('message', 'Modification a été enregistré avec succès');
               //throw $this->createNotFoundException('Cet ensignant n\'existe pas');
           }
        
        $form = $this->createForm(EnsignantType::class, $ensignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             $this->getDoctrine()->getManager()->flush();
            $this->addFlash('message', 'Modification a été enregistré avec succès');

            

            return $this->redirectToRoute('ensignant_info');
        }

        return $this->render('profile/ensignant_info/edit_student_info.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);



        
    }
  

    /**
     * @Route("/changepassword", name="profile_changePassword")
     */
    public function change_user_password(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
      

         $user = $this->getUser();
         if ($user === null) {
            $this->addFlash('danger', 'Token Inconnu');
           return $this->redirectToRoute('app_login');
         }
         
         $form = $this->createForm(ChangePasswordFormType::class, $user);
         $form->handleRequest($request);
 
         if ($form->isSubmitted() && $form->isValid()) {
            $user->setResetToken(null);

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            //$user->setPassword($passwordEncoder->encodePassword($user, $form->get('plainPassword')));
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

             $this->addFlash('message', 'Mot de passe mis à jour');

             return $this->redirectToRoute('app_login');
         }
 
         return $this->render('profile/reset.html.twig', [
             'user' => $user,
             'form' => $form->createView(),
         ]);

         


      
 
        
     }
}
