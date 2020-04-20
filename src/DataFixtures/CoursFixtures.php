<?php

namespace App\DataFixtures;

use App\Entity\Cours;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CoursFixtures extends BaseFixture
{

    
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'cours', function($i) use ($manager) {
            $cours = new Cours();
            $cours->setNomCours($this->faker->text);
            $cours->setDescription($this->faker->text);
            $cours->setObjectif($this->faker->text);
            $cours->setTag($this->faker->name);
            $cours->setLogicielRequise($this->faker->text);
            $cours->setNiveau($this->faker->text);
            $cours->setImage($this->faker->imageUrl);
            $cours->setDateCreation($this->faker->dateTimeAD);
            $cours->setDernierModification($this->faker->dateTimeAD);

            return $cours;
        });
        

        $manager->flush();
    }


}

