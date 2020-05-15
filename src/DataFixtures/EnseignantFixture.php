<?php

namespace App\DataFixtures;
use App\Entity\Enseignant;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EnseignantFixture extends BaseFixture  implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['EnseignantFixture'];
    }
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function loadData(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);


        $this->createMany(10, 'Enseignant', function($i) use ($manager) {
            
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


            $enseignant = new Enseignant();
            $enseignant->setUserId($user);
            $enseignant->setTitre($this->faker->lastName);


            
            return $enseignant;
        });
        $manager->flush();
    }
}
