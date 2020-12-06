<?php

namespace App\Repository;

use App\Entity\Referentiels;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Referentiels|null find($id, $lockMode = null, $lockVersion = null)
 * @method Referentiels|null findOneBy(array $criteria, array $orderBy = null)
 * @method Referentiels[]    findAll()
 * @method Referentiels[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferentielsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Referentiels::class);
    }

    // /**
    //  * @return Referentiels[] Returns an array of Referentiels objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findOneByrefGRpCompetence($idRef, $idGrpC): ?Referentiels
    {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.groupeDeCompetences', 'grpComp')
            ->andWhere('grpComp.id = :val')
            ->andWhere('r.id = :id')
            ->setParameter('id', $idRef)
            ->setParameter('val', $idGrpC)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
