<?php

namespace App\DataPersister;

use App\Entity\Referentiels;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class ReferentielDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     *@var EntityManagerInterface
     */
    protected $_em;
    public function __construct(EntityManagerInterface $_em)
    {
        $this -> _em = $_em;
    }
    /**
     * {@inheritDoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Referentiels;
    }
    /**
     * @param Referentiels $data
     */
    public function persist($data, array $context = [])
    {
        $data -> setLibelle($data -> getLibelle())
              -> setPresentation($data -> getPresentation())
              -> setProgramme($data -> getProgramme())
              -> setPromo($data -> getPromo())
              -> setCritereDadmission($data -> getCritereDadmission())
              -> setCritereDevaluation($data -> getCritereDevaluation());
        $this-> _em -> persist($data);
        $this-> _em -> flush();

        return $data;
    }
    public function remove($data, array $context = [])
    {
        $data -> setArchive(1);
        $this -> _em -> persist($data);
        $this -> _em -> flush();
    }
}