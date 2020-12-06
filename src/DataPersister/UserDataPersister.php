<?php
namespace App\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;

class UserDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * @var EntityManagerInterface 
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
        return $data instanceof User;
    }
    /**
     * @param User $data
     */
    public function persist($data, array $context = [])
    {
        return $data;
    }
    public function remove($data, array $context = [])
    {
        $data -> setArchive(1);
        $this -> _em -> persist($data);
        $this-> _em -> flush();
    }
}