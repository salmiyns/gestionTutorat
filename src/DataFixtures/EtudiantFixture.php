<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Etudiant;
use App\Entity\User;
use App\Repository\UserRepository;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EtudiantFixture extends BaseFixture implements FixtureGroupInterface
{

    public static function getGroups(): array
    {
        return ['EtudiantFixture'];
    }

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'Etudiant', function($i) use ($manager) {

            $user = new User();
            $user->setEmail(sprintf('user%d@example.com', $i));
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
            $user->setRoles(['ROLE_ADMIN']);


            $etudiant = new Etudiant();
            $etudiant->setMatricule(sprintf('GIN%d', $i));
            $etudiant->setFiliere(sprintf('FILIER%d', $i));
            $etudiant->setUserId($user);

            
            return $etudiant;
        });
        

        $manager->flush();
    }
}

