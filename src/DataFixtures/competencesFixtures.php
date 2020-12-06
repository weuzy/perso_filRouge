<?php


namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Promo;
use App\Entity\Groupe;
use App\Entity\Niveau;
use App\Entity\Actions;
use App\Entity\Competences;
use App\Entity\Referentiels;
use App\Entity\GroupeDeCompetence;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class competencesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
       $groupeDeComp = ["Développer le front-end d’une application web", "Développer le back-end d’une application web"];
        $competences = ["Créer une base de données", "Développer les composants d’accès aux données", "Élaborer et mettre en œuvre des composants dans une application de gestion de contenu ou e-commerce", "Maquetter une application", "Réaliser une interface utilisateur web", "Développer une interface utilisateur web dynamique"];
        $niveaux = ["niveau 1", "niveau 2", "niveau 3"];
        foreach ($groupeDeComp as $key => $libelle) {
            $groupe = new GroupeDeCompetence();
            $groupe -> setLibelle($libelle)
                    -> setDescriptif($faker -> text);
           // $manager-> persist($groupe);
            for ($i=1; $i <=3 ; $i++) { 
                $compete = new Competences();
                $compete -> setLibelle($faker -> randomElement($competences))
                         -> setDescriptif($faker -> text);
                $groupe -> addCompetence($compete);
                for ($i=1; $i <=3 ; $i++) { 
                    $niveau = new Niveau();
                    $niveau -> setLibelle($faker -> randomElement($niveaux))
                            -> setDescription($faker-> text)
                            -> setCriterDEvaluation($faker -> text);
                   $compete -> addNiveau($niveau);
                 //  $manager -> persist($niveau);
                    for ($i=1; $i <=3 ; $i++) { 
                        $action  = new Actions();
                        $action -> setLibelle($faker -> text)
                                -> setNiveau($niveau);
                     //  $manager -> persist($action);
                     }
                   }
                //$manager -> persist($compete);
            }
            
        }
        $promos =["Cohorte1","Cohorte2" ,"Cohorte3"];
        $langues = ["français", "anglais", "autres"];
        foreach ($promos as $key => $libelle) {
            $promo = new Promo() ;
            $promo  ->setLibelle ($libelle)
                    ->setLangue($faker -> randomElement($langues))
                    ->setDescription($faker -> text)
                    ->setCreateAt($faker -> dateTimeThisYear)
                    ->setEndAt($faker -> dateTimeThisYear)
                    ->setReferenceAgate($faker -> text)
                    ->setChoixDeLaFabrique($faker -> text)
                    ->setLieu("Sonatel Academy");
            $avatar = $faker->imageUrl($width = 500, $height = 400);
            $promo->setAvatar($avatar);
            $manager ->persist($promo);
            //$manager->flush();
            $groupes=["G1","G2","G3","G4"];
            foreach ($groupes as  $libelle1){
                $grp =new Groupe() ;
                $grp ->setLibelle ($libelle1)
                     ->setPeriode("2 semaines")
                     ->setCreateAt($faker-> dateTime)
                     ->setPromo($promo);
                $manager ->persist($grp);
            }
        }
        for ($i=1; $i <= 3 ; $i++) { 
            $referentiel= new Referentiels();
            $referentiel-> setLibelle("Référentiels".$i)
                        -> setPresentation($faker -> text)
                        -> setProgramme($faker -> text)
                        -> setCritereDAdmission($faker -> text)
                        -> setCritereDEvaluation($faker -> text)
                        -> addGroupeDeCompetence($groupe)
                        -> setPromo($promo);
            $manager -> persist($referentiel);
        }
        $manager -> flush();
    }
}