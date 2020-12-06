<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use App\Entity\GroupeDeTag;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class tagFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {/*
        $tags = ["HTML5", "CSS3", "Node JS", "Javascript"];
        $groupes_de_tags = ["Développement Mobile", "Systèmes et réseaux","Objets connectés"];
        foreach ($tags as $key => $lib) {
            $tag = new Tag();
                $tag -> setLibelle($lib);
                $manager -> persist($tag);
            }
        foreach ($groupes_de_tags as $key => $libelle) {
            $grp_tag = new GroupeDeTag();
            $grp_tag -> setLibelle($libelle)
                     -> addTag($tag);
            $manager -> persist($grp_tag);
            }
            
        $manager -> flush();*/
        
    }
}