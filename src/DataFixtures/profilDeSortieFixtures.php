<?php

namespace App\DataFixtures;

use App\Entity\ProfilDeSortie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class profilDeSortieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {/*
        $metiers = ["Développeur front", "Développeur back", "fullstack", "CMS", "Intégrateur", "Designer", "CM", "Data"];
        foreach ($metiers as $libelle) {
            $profilDeSortie = new ProfilDeSortie();
            $profilDeSortie -> setLibelle($libelle);
            $manager -> persist($profilDeSortie);
            $manager -> flush();
        }*/
    }
}