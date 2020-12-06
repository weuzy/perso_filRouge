<?php
namespace App\DataProvider;

use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\PaginationExtension;
use App\Entity\Profil;

class UserDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $managerRegistry;
    private $paginationExtension;
    private $context;
    public function __construct(ManagerRegistry $managerRegistry, PaginationExtension $paginationExtension)
    {
       $this->managerRegistry = $managerRegistry;
       $this->paginationExtension = $paginationExtension;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return User::class === $resourceClass || Profil::class === $resourceClass;
    }
    public function getCollection(string $resourceClass, string $operationName = null)
    {
        $queryBuilder = $this->managerRegistry
                             ->getManagerForClass($resourceClass)
                             ->getRepository($resourceClass)->createQueryBuilder('user')
                             ->where('user.archive = :archive')
                             ->setParameter('archive', false);
          
        return $queryBuilder->getQuery()->getResult(); 
    }

}