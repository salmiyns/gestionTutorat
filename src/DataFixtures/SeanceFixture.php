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
            $user->setDateOfBirth('1985-04-01');
            $user->setProfilePic('http://127.0.0.1:8000/build/images/profile.jpg');
            $user->setActivationCode("");
            $user->setRegistrationDate(null);
            $user->setStatus("1");
            $user->setRoles(['ROLE_Enseignant']);

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
            $proposition->setCours($cours);
            $proposition->setTuteur($tuteur);
            $proposition->setTitre($this->faker->title);
            $proposition->setDateCreation($this->faker->dateTimeAD);
            $proposition->setDateModification($this->faker->dateTimeAD);
            $proposition->setStatut('valide');


            $realisation = new Realisation();
            $realisation->setTitre($this->faker->text);
            $realisation->setDesicription($this->faker->text);
            $realisation->setDateCreation($this->faker->dateTimeAD);
            $realisation->setDateModification($this->faker->dateTimeAD);
            $realisation->setProposition($proposition); 
            $realisation->setCours($cours); 
            




            $seance = new Seance();
            $seance->setTitre($this->faker->name);
            $seance->setDescription($this->faker->text);
            $seance->setDurée("2 H");
            $seance->setTemps($this->faker->dateTimeAD);
            $seance->setRealisation($realisation);

            $manager->persist( $cours);
            $manager->persist( $tuteur);
            $manager->persist( $proposition);
            $manager->persist( $realisation);
 
            return $seance;
        });
        $manager->flush();
    }
}
