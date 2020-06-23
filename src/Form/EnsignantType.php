<?php

namespace App\Form;

use App\Entity\Enseignant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnsignantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Titre',TextareaType::class)
            ->add('departement',TextareaType::class)
            //->add('status')
            //->add('type')
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    'Enseignant Permanent'=>'1',
                    'Enseignant Vacataire'=>'2',
                    
                ],
                'multiple'=>false,
                'required' => false,
                'expanded'=>false,
                

            ])
            //->add('date_embauche')
            ->add('date_embauche', DateTimeType::class,array(
                'widget' => 'single_text',
                'html5'  => false,
                'attr' => array('id' => 'dateRangePickerSample01',
                'placeholder'=> 'date_embauche',
                 'data-toggle'=> 'flatpickr',
                 'data-flatpickr-alt-format'=>'F j, Y at H:i',
                 'data-flatpickr-date-format'=>'Y-m-d H:i',
                 'data-flatpickr-enable-time'=>'true'
                  //'data-daterangepicker-start-date' => '2020/01/01',
                 //'data-daterangepicker-single-date-picker' >= 'true'                                                    

            
            
            
            )) 
            )
            ;
            //->add('idUser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Enseignant::class,
        ]);
    }
}
