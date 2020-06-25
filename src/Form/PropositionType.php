<?php

namespace App\Form;

use App\Entity\Proposition;
use App\Entity\Tuteur;
use App\Repository\TuteurRepository;
use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class PropositionType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();
        if (!$user) {
            throw new \LogicException(
                'The FriendMessageFormType cannot be used without an authenticated user!'
            );
        }


        
        

        $builder
            ->add('titre')
            //->add('description',TextareaType::class, [
            //    'help' => 'Choose something catchy!'
            //])
            ->add('description', TextareaType::class, array('attr' => array('class' => 'ckeditor')))

          
          /*  ->add('date_creation',null, [
                'widget' => 'single_text',
                'data' => new \DateTime(),
                'mapped' => false
                
            ])
            
            ->add('date_modification',null, [
                'widget' => 'single_text',
                'data' => new \DateTime(),
                'mapped' => false
                
            ])*/
           /*  ->add('statut',null, [
                'data' => 'valide',
                
            ])
          
            ->add('tuteur', EntityType::class, [
                'class' => Tuteur::class,
                'query_builder' => function(TuteurRepository $repo)use ($user) {
                    return $repo->findByConnectedUserId_Byqb($user);
                }
            ])*/
            ;
           
            
            //->add('cours')
           // ->add('tuteur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Proposition::class,

            ]);
    }
}
