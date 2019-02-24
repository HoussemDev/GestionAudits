<?php

namespace App\Repository;

use App\Entity\CB;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CB|null find($id, $lockMode = null, $lockVersion = null)
 * @method CB|null findOneBy(array $criteria, array $orderBy = null)
 * @method CB[]    findAll()
 * @method CB[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CBRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CB::class);
    }

    // /**
    //  * @return CB[] Returns an array of CB objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CB
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
