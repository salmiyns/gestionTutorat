<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Etudiant;
use Faker\Factory;

class EtudiantFixture extends BaseFixture
{

    


    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'Etudiant', function($i) use ($manager) {
            $etudiant = new Etudiant();
            $etudiant->setUserId($i);
            $etudiant->setMatricule(sprintf('GIN%d', $i));
            $etudiant->setFiliere(sprintf('FILIER%d', $i));
          
            
            return $etudiant;
        });
        

        $manager->flush();
    }
}

