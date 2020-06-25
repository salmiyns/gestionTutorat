<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Proposition;
use App\Repository\PropositionRepository;
use App\Repository\TuteurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;

class CoursType extends AbstractType
{
    
    private $security;
    private $propositionRepository;
    private $tuteurRepository;


    public function __construct(Security $security ,PropositionRepository $propositionRepository ,TuteurRepository $tuteurRepository )
    {
        $this->security = $security;
        $this->propositionRepository = $propositionRepository;
        $this->tuteurRepository = $tuteurRepository;

    }


    public function buildForm(FormBuilderInterface $builder, array $options )
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
        $propositions=$tuteur->getPropositions();
        

        if(is_null($tuteur)){
            throw new \LogicException(
                "ce compte Tuteur n'existe pas au base donnee"
            );
            
          
        }


       
         //$tuteur = $this->tuteurRepository->findByConnectedUserId($user);

        $builder
            ->add('nom_cours')
            //->add('description')
            ->add('description', TextareaType::class, array('attr' => array('class' => 'ckeditor')))
            ->add('objectif', TextareaType::class, array('attr' => array('class' => 'ckeditor')))
            ->add('tag')
            //->add('competences_req')
            ->add('niveau',ChoiceType::class, [
                'choices'  => [
                    'débutant' => true,
                    'avancé' => false,
                    'débutant/avancé ' => false,
                ],
            ])
            ;
            $imageConstraints = [
                new Image([
                    'maxSize' => '5M'
                ])
            ];


            if (!$isEdit || !$cours->getImage()) {
                $imageConstraints[] = new NotNull([
                    'message' => 'S il vous plaît Ajouter une image',
                ]);
            }


            $builder
            ->add('image', FileType::class, [
                'mapped' => false,
                'required'=> false,
                'constraints' => $imageConstraints
            ])
            //->add('date_creation')
            //->add('dernier_modification')
            ->add('proposition', EntityType::class, [
                'class' => Proposition::class,
                'choices' => $propositions,

               
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
