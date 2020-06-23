<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\User;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Migrations\Version\Factory;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
class UserFixture extends BaseFixture implements FixtureGroupInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public static function getGroups(): array
    {
        return ['UserFixture'];
    }
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function($i) use ($manager) {
            $user = new User();
            $user->setEmail(sprintf('user%d@example.com', $i));
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));

            $date= new DateTime();

            $user->setFirstname($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
           // $user->setDateNaissance($date);
           // $user->setProfilePic('http://127.0.0.1:8000/build/images/profile.jpg');
        
            $user->setRoles(['ROLE_ADMIN']);
            $user->setSexe("Homme");
            $user->setIsActive(true);
            $user->setCreatedAt($date);
            $user->setUpdatedAt($date);
            $user->setVerified(true);

            

            return $user;
        });
        

        $manager->flush();
    }
}