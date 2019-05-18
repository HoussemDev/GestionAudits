<?php

namespace App\Repository;

use App\Entity\Audit;
use App\Entity\AuditSearch;
use App\Entity\CB;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Audit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Audit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Audit[]    findAll()
 * @method Audit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuditRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, Audit::class);
	}


	/**
	 * @return Query
	 */

	public function findAllVisibleQuery(AuditSearch $search): Query
	{
		$query = $this->findVisibleQuery();

		if ($search->getAudittitle()) {
			$audittitle = $search->getAudittitle();
			$query = $query
				->andWhere('p.Title LIKE :audittitle')
				->setParameter('audittitle', '%' . $audittitle . '%');
		}

		if ($search->getAuditstandard()) {
			$auditstandard = $search->getAuditstandard();
			$query = $query
				->andWhere('p.standard LIKE :auditstandard')
				->setParameter('auditstandard', '%' . $auditstandard . '%');
		}


		return $query->getQuery();

	}



//	/**
//	 * @return Query
//	 */
//
//	public function findAllVisibleAuditCb(CB $cb ,AuditSearch $search): Query
//	{
//		$query = $this->findBy($cb);
//
////		if ($search->getAudittitle()) {
////			$audittitle = $search->getAudittitle();
////			$query = $query
////				->andWhere('p.Title LIKE :audittitle')
////				->setParameter('audittitle', '%' . $audittitle . '%');
////		}
////
////		if ($search->getAuditstandard()) {
////			$auditstandard = $search->getAuditstandard();
////			$query = $query
////				->andWhere('p.standard LIKE :auditstandard')
////				->setParameter('auditstandard', '%' . $auditstandard . '%');
////		}
//
//
//		return $query->getQuery();
//
//	}

	private function findVisibleQuery(): QueryBuilder
	{
		return $this->createQueryBuilder('p');
//			->where('p.id = true');

	}

	// /**
	//  * @return Audit[] Returns an array of Audit objects
	//  */
	/*
	public function findByExampleField($value)
	{
		return $this->createQueryBuilder('a')
			->andWhere('a.exampleField = :val')
			->setParameter('val', $value)
			->orderBy('a.id', 'ASC')
			->setMaxResults(10)
			->getQuery()
			->getResult()
		;
	}
	*/

	/*
	public function findOneBySomeField($value): ?Audit
	{
		return $this->createQueryBuilder('a')
			->andWhere('a.exampleField = :val')
			->setParameter('val', $value)
			->getQuery()
			->getOneOrNullResult()
		;
	}
	*/
}
