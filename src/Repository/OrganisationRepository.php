<?php

namespace App\Repository;

use App\Entity\AuditSearch;
use App\Entity\CB;
use App\Entity\Organisation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Organisation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Organisation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Organisation[]    findAll()
 * @method Organisation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganisationRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, Organisation::class);
	}

	// /**
	//  * @return Organisation[] Returns an array of Organisation objects
	//  */
	/*
	public function findByExampleField($value)
	{
		return $this->createQueryBuilder('o')
			->andWhere('o.exampleField = :val')
			->setParameter('val', $value)
			->orderBy('o.id', 'ASC')
			->setMaxResults(10)
			->getQuery()
			->getResult()
		;
	}
	*/

	/*
	public function findOneBySomeField($value): ?Organisation
	{
		return $this->createQueryBuilder('o')
			->andWhere('o.exampleField = :val')
			->setParameter('val', $value)
			->getQuery()
			->getOneOrNullResult()
		;
	}
	*/


	public function countOrgInCb()
	{
		$qb = $this->createQueryBuilder('o')
			->Join('o.cb', 'c')
			->select('c.name, count(o.id)')
			->groupBy('o.cb')
			->getQuery()
			->getResult();

		return $qb;

	}

	/**
	 * @return array
	 */

	public function countorg(): array
	{
		$qb = $this->createQueryBuilder('l')

			->select('COUNT(l)')

			->getQuery();


		return $qb->getArrayResult();

	}




//	/**
//	 * @return array
//	 */

//	public function findAllVisibleAuditCb( $cb ,AuditSearch $search): array
//	{
//
//		$this->createQueryBuilder('p');
////			->where('p.cb = true');
//		$query = $this->findBy($cb);
//
//		if ($search->getAudittitle()) {
//			$audittitle = $search->getAudittitle();
//			$query = $query
//				->andWhere('p.cb LIKE :audittitle')
//				->setParameter('audittitle', '%' . $audittitle . '%');
//		}
////
////		if ($search->getAuditstandard()) {
////			$auditstandard = $search->getAuditstandard();
////			$query = $query
////				->andWhere('p.standard LIKE :auditstandard')
////				->setParameter('auditstandard', '%' . $auditstandard . '%');
////		}
//
//
//		return $query;
//
//	}
//
//
//	private function findVisibleQuery(): QueryBuilder
//	{
//		return $this->createQueryBuilder('p')
//			->where('p. = true');
//
//	}


}
