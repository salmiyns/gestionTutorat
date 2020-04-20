<?php

namespace App\DataFixtures;
use Faker\Factory;
use App\Entity\Seance;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SeanceFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->createMany(10, 'Seance', function($i) use ($manager) {
            $seance = new Seance();
            $seance->setCours($i);
            $seance->setClasse($this->faker->text);
            $seance->setObjectif($this->faker->name);
            $seance->setTuteur($i);
            $seance->setDate($this->faker->dateTimeAD);
 
            return $seance;
        });
        $manager->flush();
    }
}
