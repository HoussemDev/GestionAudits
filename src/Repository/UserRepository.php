<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

	/**
	 * @return Query
	 */

	public function findAllVisibleQuery(UserSearch $search): Query
	{
		$query = $this->findAllUsers();

		if ($search->getUsername()) {
			$username = $search->getUsername();

//			dump($username);
//			die();


			$query = $query
				->andWhere('p.username LIKE :username')
				->setParameter('username', '%' . $username . '%');
		}



		return $query->getQuery();

	}

//	/**
//	 * @return Query
//	 */
//
//	public function findAllCBAdminUser(User $cbusers): Query
//	{
////		$query = $this->findAllUsers();
//
////		if ($search->getUsername()) {
////			$username = $search->getUsername();
//
////			dump($username);
////			die();
//		return $this->createQueryBuilder('u')
//			->andWhere('u.roles = :ROLE_CBADMIN')
////			->setParameter('val', $value)
//			->getQuery()
//			->getOneOrNullResult();
//
////			$query = $query
////				->andWhere('p.roles LIKE :ROLE_CBADMIN');
////				->setParameter('username', '%' . $username . '%');
////		}
//
//
//
////		return $query->getQuery();
//
//	}


	private function findAllUsers(): QueryBuilder
	{
		return $this->createQueryBuilder('p');
//			->where('p.id = true');

	}
}
