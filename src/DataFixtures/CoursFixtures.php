<?php

namespace App\DataFixtures;

use App\Entity\Cours;
use App\Entity\Demande;
use App\Entity\Tutore;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CoursFixtures extends BaseFixture
{

    
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'cours', function($i) use ($manager) {
            $cours = new Cours();
            $demende=new Demande();
             
            $cours->setNomCours($this->faker->text);
            $cours->setDescription($this->faker->text);
            $cours->setObjectif($this->faker->text);
            $cours->setTag($this->faker->name);

            $cours->setNiveau($this->faker->text);
            $cours->setImage($this->faker->imageUrl);
            $cours->setDateCreation($this->faker->dateTimeAD);
            $cours->setDernierModification($this->faker->dateTimeAD);

            
            

            return $cours;
        });
        

        $manager->flush();
    }


}

