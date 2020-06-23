<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Matricule',TextareaType::class)
            ->add('filiere',TextareaType::class)
            //->add('niveau')
            ->add('niveau',ChoiceType::class,[
                'choices'=>[
                    '1 ere Annee'=>'1',
                    '2 eme annee'=>'2',
                    '3 eme annee'=>'3',
                    '4 eme annee'=>'4',
                    '5 eme annee'=>'5',
                ],
                'multiple'=>false,
                'required' => false,
                'expanded'=>false,
                

            ])
            //->add('idUser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
