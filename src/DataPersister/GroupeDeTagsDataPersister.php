<?php

namespace App\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\GroupeDeTag;

class GroupeDeTagsDataPersister implements ContextAwareDataPersisterInterface
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
        return $data instanceof GroupeDeTag;
    }
    /**
     * @param GroupeDeTag $data
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
        foreach ($data -> getTags() as $tags) {
            $tags -> addTag(null);
        }
        $this -> _em -> flush();
    }
}