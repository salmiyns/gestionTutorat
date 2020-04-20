<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Realisation;


class RealisationFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->createMany(10, 'Realisation', function($i) use ($manager) {
            $realisation = new Realisation();
            $realisation->setDateCreation($this->faker->dateTimeAD);
            $realisation->setDateModification($this->faker->dateTimeAD);


            
            return $realisation;
        });

        $manager->flush();
    }
}
