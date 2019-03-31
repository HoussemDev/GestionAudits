<?php

namespace App\Repository;

use App\Entity\Finding;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Finding|null find($id, $lockMode = null, $lockVersion = null)
 * @method Finding|null findOneBy(array $criteria, array $orderBy = null)
 * @method Finding[]    findAll()
 * @method Finding[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FindingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Finding::class);
    }

    // /**
    //  * @return Finding[] Returns an array of Finding objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Finding
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
