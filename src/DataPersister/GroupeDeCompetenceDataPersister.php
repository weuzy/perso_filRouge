<?php

namespace App\DataPersister;

use App\Entity\GroupeDeCompetence;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class GroupeDeCompetenceDataPersister implements ContextAwareDataPersisterInterface
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
        return $data instanceof GroupeDeCompetence;
    }
    /**
     * @param GroupeDeCompetence $data
     */
    public function persist($data, array $context = [])
    {
        $data -> setLibelle($data -> getLibelle());
        $this-> _em -> persist($data);
        $this-> _em -> flush();

        return $data;
    }
    public function remove($data, array $context = [])
    {
        $data -> setArchive(1);
        $this -> _em -> persist($data);
        foreach ($data -> getCompetences() as $grpc) {
            $grpc -> removeCompetence(null);
        }
        $this -> _em -> flush();
    }
}