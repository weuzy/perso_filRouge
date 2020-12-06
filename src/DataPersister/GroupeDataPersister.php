<?php

namespace App\DataPersister;

use App\Entity\Profil;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Groupe;

class GroupeDataPersister implements ContextAwareDataPersisterInterface
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
        return $data instanceof Groupe;
    }
    /**
     * @param Groupe $data
     */
    public function persist($data, array $context = [])
    {
        $data -> setLibelle($data -> getLibelle())
              -> setPeriode($data -> getPeriode())
              -> setCreateAt($data -> getCreateAt());
        $this-> _em -> persist($data);
        $this-> _em -> flush();

        return $data;
    }
    public function remove($data, array $context = [])
    { 
        $data -> setArchive(1);
        $this -> _em -> persist($data);
        
    }
}