<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Apprenant;
use App\Entity\CM;
use App\Entity\Formateur;
use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class userFixtures extends Fixture
{
    private $password;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this -> password = $encoder;
    }
    public function load(ObjectManager $manager)
    {/*
        $faker= Factory::create('fr_FR');
        for ($i=1; $i <5 ; $i++) { 
         $admin = new Admin();
         $admin -> setPrenom($faker -> firstName)
                -> setNom($faker -> lastName)
                -> setEmail($faker -> email)
                -> setUsername($faker-> lastName)
                -> setGenre($faker -> randomElement(["M","F"])) 
                -> setPhoto($faker -> imageUrl($width = 640, $height = 480))
                -> setTelephone($faker -> phoneNumber)
                -> setArchive(0);
         $pass  =  $this -> password -> encodePassword($admin, "#19weuzy");
         $admin -> setPassword($pass);
         $admin -> setProfil($this->getReference(profilFixtures::PROFIL_ADMIN_REFERENCE));
         $manager -> persist($admin);

         $formateur = new Formateur();
         $formateur -> setPrenom($faker -> firstName)
                    -> setNom($faker -> lastName)
                    -> setEmail($faker -> email)
                    -> setUsername($faker-> lastName)
                    -> setGenre($faker -> randomElement(["M","F"])) 
                    -> setPhoto($faker -> imageUrl($width = 640, $height = 480))
                    -> setTelephone($faker -> phoneNumber)
                    -> setArchive(0);
         $pass  =  $this -> password -> encodePassword($formateur, "#19weuzy");
         $formateur -> setPassword($pass);
         $formateur -> setProfil($this->getReference(profilFixtures::PROFIL_FORMATEUR_REFERENCE));
         $manager -> persist($formateur);

         $apprenant = new Apprenant();
         $apprenant -> setAdresse($faker -> city);
         $apprenant -> setPrenom($faker -> firstName)
                    -> setNom($faker -> lastName)
                    -> setEmail($faker -> email)
                    -> setUsername($faker-> lastName)
                    -> setGenre($faker -> randomElement(["M","F"])) 
                    -> setPhoto($faker -> imageUrl($width = 640, $height = 480))
                    -> setTelephone($faker -> phoneNumber)
                    -> setArchive(0);
         $pass  =  $this -> password -> encodePassword($apprenant, "#19weuzy");
         $apprenant -> setPassword($pass);
         $apprenant -> setProfil($this->getReference(profilFixtures::PROFIL_APPRENANT_REFERENCE));
         $manager -> persist($apprenant);

         $cm = new CM();
         $cm -> setPrenom($faker -> firstName)
                    -> setNom($faker -> lastName)
                    -> setEmail($faker -> email)
                    -> setUsername($faker-> lastName)
                    -> setGenre($faker -> randomElement(["M","F"])) 
                    -> setPhoto($faker -> imageUrl($width = 640, $height = 480))
                    -> setTelephone($faker -> phoneNumber)
                    -> setArchive(0);
         $pass  =  $this -> password -> encodePassword($cm, "#19weuzy");
         $cm -> setPassword($pass);
         $cm -> setProfil($this->getReference(profilFixtures::PROFIL_CM_REFERENCE));
         $manager -> persist($cm);
        }
        
        $manager -> flush();
        */
    }
}
