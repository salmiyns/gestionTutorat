<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Tuteur;

class TuteurFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->createMany(10, 'Tuteur', function($i) use ($manager) {
            $tuteur = new Tuteur();
            $tuteur->setIdEtudiant($i);
          
            
            return $tuteur;
        });

        $manager->flush();
    }
}
