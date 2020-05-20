<?php

namespace App\DataFixtures;

use App\Entity\Cours;
use App\Entity\Demande;
use App\Entity\Etudiant;
use App\Entity\Proposition;
use App\Entity\Tuteur;
use App\Entity\Tutore;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class CoursFixtures  extends BaseFixture implements FixtureGroupInterface
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public static function getGroups(): array
    {
        return ['CoursFixture'];
    }


    
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'cours', function($i) use ($manager) {
            $user = new User();
            $user->setEmail(sprintf('Enseignant%d@example.com', $i));
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));
    
            $user->setFirstName($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
            $user->setDateOfBirth('1985-04-01');
            $user->setProfilePic('http://127.0.0.1:8000/build/images/profile.jpg');
            $user->setActivationCode("");
            $user->setRegistrationDate(null);
            $user->setStatus("1");
            $user->setRoles(['ROLE_Enseignant']);
            $user->setSexe('HOMME');


            $etudiant = new Etudiant();
            $etudiant->setMatricule(sprintf('GIN%d', $i));
            $etudiant->setFiliere(sprintf('FILIER%d', $i));
            $etudiant->setUserId($user);

            $tuteur = new Tuteur();
            $tuteur->setIdEtudiant($etudiant);
          
            $cours = new Cours();
            $cours->setDescription($this->faker->text());
            $cours->setNomCours($this->faker->text());
            $cours->setDateCreation($this->faker->dateTimeAD);
            $cours->setDernierModification($this->faker->dateTimeAD);

            $proposition = new Proposition();
            $proposition->setTuteur($tuteur);
            $proposition->setTitre($this->faker->text);
            $proposition->setDescription($this->faker->text);
            $proposition->setDateCreation($this->faker->dateTimeAD);
            $proposition->setDateModification($this->faker->dateTimeAD);
            $proposition->setStatut('valide');
            
            

            

            $cours = new Cours();            
            $cours->setNomCours($this->faker->text);
            $cours->setDescription($this->faker->text);
            $cours->setObjectif($this->faker->text);
            $cours->setTag($this->faker->name);
            $cours->setNiveau($this->faker->text);
            $cours->setImage($this->faker->imageUrl);
            $cours->setDateCreation($this->faker->dateTimeAD);
            $cours->setDernierModification($this->faker->dateTimeAD);
            $cours->setProposition($proposition);

            $manager->persist( $user);
            $manager->persist( $etudiant);
            $manager->persist( $tuteur);
            $manager->persist( $proposition);
            

            return $cours;
        });
        

        $manager->flush();
    }


}

