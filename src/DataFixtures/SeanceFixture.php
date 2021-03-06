<?php

namespace App\DataFixtures;

use App\Entity\Cours;
use App\Entity\Etudiant;
use App\Entity\Proposition;
use App\Entity\Realisation;
use Faker\Factory;
use App\Entity\Seance;
use App\Entity\Tuteur;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SeanceFixture extends BaseFixture implements FixtureGroupInterface
{

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public static function getGroups(): array
    {
        return ['SeanceFixture'];
    }
    public function loadData(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->createMany(10, 'Seance', function($i) use ($manager) {
            $user = new User();
            $user->setEmail(sprintf('Enseignant%d@example.com', $i));
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));
    
            $user->setFirstName($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
            $user->setDateOfBirth(new DateTime());
            $user->setProfilePic('http://127.0.0.1:8000/build/images/profile.jpg');
             $user->setRoles(['ROLE_Enseignant']);
            $user->setSexe('Homme');
            $user->setIsActive(true);
            $user->setVerified(true);
            $user->setCreatedAt(new DateTime());
            $user->setActivatedAt(new DateTime());




            $etudiant = new Etudiant();
            $etudiant->setMatricule(sprintf('GIN%d', $i));
            $etudiant->setFiliere(sprintf('FILIER%d', $i));
            $etudiant->setIdUser($user);

            $tuteur = new Tuteur();
            $tuteur->setIdEtudiant($etudiant);
          
    

            $proposition = new Proposition();
             $proposition->setTuteur($tuteur);
            $proposition->setTitre($this->faker->title);
            $proposition->setDateCreation($this->faker->dateTimeAD);
            $proposition->setDateModification($this->faker->dateTimeAD);
            $proposition->setStatut('valide');


            $cours = new Cours();
            $cours->setDescription($this->faker->text());
            $cours->setNomCours($this->faker->text());
            $cours->setDateCreation($this->faker->dateTimeAD);
            $cours->setDernierModification($this->faker->dateTimeAD);
            $cours->setProposition($proposition);


            $realisation = new Realisation();
            $realisation->setTitre($this->faker->text);
            $realisation->setDesicription($this->faker->text);
            $realisation->setDateCreation($this->faker->dateTimeAD);
            $realisation->setDateModification($this->faker->dateTimeAD);
            $realisation->setDateFin($this->faker->dateTimeAD);

             $realisation->setCours($cours); 
            $realisation->setTuteur($tuteur);
            




            $seance = new Seance();
            $seance->setTitre($this->faker->name);
            $seance->setDescription($this->faker->text);
            $seance->setDuree("2 H");
            $seance->setTemps($this->faker->dateTimeAD);
            $seance->setRealisation($realisation);

            $manager->persist( $user);
            $manager->persist( $etudiant);
            $manager->persist( $tuteur);

            $manager->persist( $cours);
            $manager->persist( $proposition);
            $manager->persist( $realisation);
 
            return $seance;
        });
        $manager->flush();
    }
}
