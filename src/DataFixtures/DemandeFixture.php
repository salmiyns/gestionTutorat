<?php

namespace App\DataFixtures;

use App\Entity\Cours;
use App\Entity\Demande;
use App\Entity\Etudiant;
use App\Entity\Tutore;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DemandeFixture extends BaseFixture
{
    public static function getGroups(): array
    {
        return ['DemandeFixture'];
    }
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function loadData(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->createMany(10, 'Demande', function($i) use ($manager) {
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

            $cours = new Cours();
            $cours->setDescription($this->faker->text());
            $cours->setNomCours($this->faker->text());
            $cours->setDateCreation($this->faker->dateTimeAD);
            $cours->setDernierModification($this->faker->dateTimeAD);


            $tutore = new Tutore();
            $tutore->setEtudiant($etudiant);

            $demande = new Demande();
            $demande->setTutore($tutore);
            $demande->setCours($cours);

            $manager->persist( $cours);

            $manager->persist( $tutore);


           

            

            return $demande;
        });

        $manager->flush();
    }
}
