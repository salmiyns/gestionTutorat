<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var User|null $user */
        $user =$options['data']??null;
        $isEdit = $user ?? $user->getId();


        if (!$user) {
            throw new \LogicException(
                'Utilisateur introuvable'
            );
        }

        $builder
            ->add('email',EmailType::class, [
                'required' => false,
                 
            ])
            //->add('roles')
            ->add('roles',ChoiceType::class,[
                'choices'=>[
                    'Admin'=>'ROLE_ADMIN',
                    'Enseignant'=>'ROLE_ENSEIGNANT',
                    'Tuteur'=>'ROLE_TUTEUR',
                    'Tutoré'=>'ROLE_TUTORE',
                ],
                'multiple'=>true,
                'required' => true,
                'expanded'=>true,
                

            ])
            //->add('password')
            ->add('firstName',TextType::class, [
                'required' => false,
                 
            ])
            ->add('lastName',TextType::class, [
                'required' => false,
                 
            ])
            ->add('date_of_birth', DateTimeType::class,array(
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
            ;
            $imageConstraints = [
                new Image([
                    'maxSize' => '5M'
                ])
            ];


            if (!$isEdit || !$user->getImage()) {
                $imageConstraints[] = new NotNull([
                    'message' => 'S il vous plaît Ajouter une image',
                ]);
            }

            $builder
            ->add('imageFile', VichImageType::class, [
                 'required'=>false,
                 'allow_delete' => false,
                 'image_uri' => false,

                 'download_uri' => false,
                 'attr' => ['Style' => 'display:none;'],
                
            ])
            ->add('telephone',TextType::class, [
                'required' => false,
                 
            ])
            ->add('sexe',ChoiceType::class, [
                'choices'  => [
                    'Homme' => true,
                    'Femme' => false,
                    
                ],
                 
            ])
            ->add('adresse',TextareaType::class)
            ->add('about',TextareaType::class, [
                'required' => false,
                 
            ])
            //->add('isActive')
            //->add('createdAt')
            //->add('updatedAt')
            //->add('activatedAt')
            //->add('isVerified')
            //->add('activation_token')
            //->add('reset_token')
            //->add('etudiant')
            //->add('enseignant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
