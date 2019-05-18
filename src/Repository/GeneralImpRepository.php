<?php

namespace App\Repository;

use App\Entity\GeneralImp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GeneralImp|null find($id, $lockMode = null, $lockVersion = null)
 * @method GeneralImp|null findOneBy(array $criteria, array $orderBy = null)
 * @method GeneralImp[]    findAll()
 * @method GeneralImp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GeneralImpRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GeneralImp::class);
    }

    // /**
    //  * @return GeneralImp[] Returns an array of GeneralImp objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GeneralImp
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
