<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Proposition;
use App\Entity\Realisation;
use App\Repository\CoursRepository;
use App\Repository\PropositionRepository;
use App\Repository\TuteurRepository;
use DateTime;
use Doctrine\DBAL\Types\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class RealisationType extends AbstractType
{
     
    private $security;
    private $coursRepository;
    private $tuteurRepository;


    public function __construct(Security $security ,CoursRepository $coursRepository ,TuteurRepository $tuteurRepository )
    {
        $this->security = $security;
        $this->coursRepository = $coursRepository;
        $this->tuteurRepository = $tuteurRepository;

    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();
        
        /** @var Cours|null $cours */
        $cours =$options['data']??null;
        $isEdit = $cours ?? $cours->getId();

        if (!$user) {
            throw new \LogicException(
                'The FriendMessageFormType cannot be used without an authenticated user!'
            );
        }

        $etudiant=$user->getEtudiant();
        if(is_null($etudiant)){
            throw new \LogicException(
                "ce compte etudiant n'existe pas au base donnee"
            );
            
        }

        $tuteur =$etudiant->getTuteurr();

        if(is_null($tuteur)){
            throw new \LogicException(
                "ce compte Tuteur n'existe pas au base donnee"
            );
            
          
        }

        //$tuteur = $this->tuteurRepository->findByConnectedUserId($user);
 
        $builder
            ->add('titre')
            ->add('desicription', TextareaType::class, array('attr' => array('class' => 'ckeditor')))
            //->add('date_creation')
            //->add('date_modification')
            //->add('proposition') placeholder="Date example"   
            ->add('date_fin',null, array(
                'widget' => 'single_text',
                  'constraints' => [new NotBlank(['message'=>'vous devez choisir une date fin !']),
                new NotNull(['message'=>'vous devez choisir une date fin !'])] ,  

                'attr' => array('id' => 'dateRangePickerSample01',
                'placeholder'=> 'date fin du realisation',
                 'data-toggle'=> 'flatpickr',
                  //'data-daterangepicker-start-date' => '2020/01/01',
                 //'data-daterangepicker-single-date-picker' >= 'true'                                                    

            
            
            
            )) )
            
            ->add('cours', EntityType::class, [
                'class' => Cours::class,
                'choices' => $this->coursRepository->find_Cours_ByTuteurId($tuteur),

               
            ]) 
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Realisation::class,
        ]);
    }
}
