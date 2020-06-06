<?php

namespace App\Form;

use App\Entity\Realisation;
use App\Entity\Seance;
use App\Repository\RealisationRepository;
use App\Repository\TuteurRepository;
use DateTime;
use Doctrine\DBAL\Types\DateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security as CoreSecurity;
use Symfony\Component\Validator\Constraints\NotNull;

class SeanceType extends AbstractType
{
    private $security;
    private $realisationRepository;
    private $tuteurRepository;

    public function __construct(CoreSecurity $security ,RealisationRepository $realisationRepository ,TuteurRepository $tuteurRepository )
    {
        $this->security = $security;
        $this->realisationRepository = $realisationRepository;
        $this->tuteurRepository = $tuteurRepository;

    }



    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $user = $this->security->getUser();
        
        /** @var Realisation|null $realisation */
        $realisation =$options['data']??null;
        $isEdit = $realisation ?? $realisation->getId();

        if (!$user) {
            throw new \LogicException(
                'The FriendMessageFormType cannot be used without an authenticated user!'
            );
        }

       // $realisations = $this->realisationRepository->getRealisation_byUser($user);
 
        //dd($realisations);


        $builder
            ->add('titre')
            ->add('description', TextareaType::class, array('attr' => array('class' => 'ckeditor')))
            ->add('temps', DateTimeType::class,array(
                'widget' => 'single_text',
                'html5'  => false,
                'attr' => array('id' => 'dateRangePickerSample01',
                'placeholder'=> 'date prévue pour cette leçon',
                 'data-toggle'=> 'flatpickr',
                 'data-flatpickr-alt-format'=>'F j, Y at H:i',
                 'data-flatpickr-date-format'=>'Y-m-d H:i',
                 'data-flatpickr-enable-time'=>'true'
                  //'data-daterangepicker-start-date' => '2020/01/01',
                 //'data-daterangepicker-single-date-picker' >= 'true'                                                    

            
            
            
            )) 
            )
            ->add('duree' ,TextType::class,array(                
                'attr' => array(                    
                            'placeholder'=> 'date prévue pour cette leçon',
                            'data-toggle'=> 'touch-spin',
                            'data-min'=>'0',
                            'data-max'=>'60',
                            'data-step'=>'1'
                            
                            //'data-daterangepicker-start-date' => '2020/01/01',
                 //'data-daterangepicker-single-date-picker' >= 'true'  
                            )                                           

            
            
                
                ) 
            )     
            
           
            ->add('realisation', EntityType::class, array(
                'class' => Realisation::class,   
                'mapped'=> true,            
                'query_builder' => function(RealisationRepository $realisationRepository)use ($user) {
                    return $realisationRepository->getRealisation_byUser($user);
                } 

               )
            
          
            )
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Seance::class,
        ]);
    }
}
