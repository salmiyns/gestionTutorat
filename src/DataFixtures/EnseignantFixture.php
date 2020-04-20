<?php

namespace App\DataFixtures;
use App\Entity\Enseignant;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EnseignantFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->createMany(10, 'Enseignant', function($i) use ($manager) {
            $enseignant = new Enseignant();
            $enseignant->setUserId($i);

            
            return $enseignant;
        });
        $manager->flush();
    }
}
