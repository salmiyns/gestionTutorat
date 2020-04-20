<?php

namespace App\DataFixtures;
use App\Entity\Demande;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DemandeFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->createMany(10, 'Demande', function($i) use ($manager) {
            $demande = new Demande();
            $demande->setIdEtudiant($i);
            $demande->setDateModification($this->faker->dateTimeAD);
            $demande->setDateCreation($this->faker->dateTimeAD);

            return $demande;
        });

        $manager->flush();
    }
}
