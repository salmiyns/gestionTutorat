<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Proposition;

class PropositionFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
 
        $this->createMany(10, 'Proposition', function($i) use ($manager) {
            $proposition = new Proposition();
            $proposition->setTuteur($i);
            $proposition->setCours($i);
            $proposition->setTuteur($i);

            $proposition->setDateCreation($this->faker->dateTimeAD);
            $proposition->setDateModification($this->faker->dateTimeAD);


            
            return $proposition;
        });


        $manager->flush();
    }
}
