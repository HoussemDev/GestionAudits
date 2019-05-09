<?php

namespace App\DataFixtures;

use App\Entity\Audit;
use App\Entity\Auditor;
use App\Entity\CB;
use App\Entity\Organisation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
	/**
	 * @var UserPasswordEncoderInterface
	 */
	private $passwordEncoder;




	private const USERS = [
		[
			'username' => 'john_doe',
			'email' => 'john_doe@doe.com',
			'password' => 'john123',
			'fullName' => 'John Doe',
			'roles' => [User::ROLE_USER]
		],
		[
			'username' => 'rob_smith',
			'email' => 'rob_smith@smith.com',
			'password' => 'rob12345',
			'fullName' => 'Rob Smith',
			'roles' => [User::ROLE_USER]

		],
		[
			'username' => 'super_admin',
			'email' => 'super_admin@admin.com',
			'password' => 'admin12345',
			'fullName' => 'Micro Admin',
			'roles' => [User::ROLE_ADMIN]
		],
		[
			'username' => 'marry_gold',
			'email' => 'marry_gold@gold.com',
			'password' => 'marry12345',
			'fullName' => 'Marry Gold',
			'roles' => [User::ROLE_USER]
		],
	];

	public function __construct(UserPasswordEncoderInterface $passwordEncoder )
	{
		$this->passwordEncoder = $passwordEncoder;
	}

	public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);



//		    $this->loadCBS($manager);
//			$this->loadOrganisations($manager);
//			$this->loadAudits($manager);
		   $this->loadUsers($manager);
//		   $this->loadAuditors($manager);

	}

	private function loadOrganisations(ObjectManager $manager)
	{
//		for ($i = 1; $i < 10; $i++) {
			$organisation = new Organisation();
			$organisation->setNumber(rand(0,100));
			$organisation->setName('Organisation'. rand(0,100));
			$organisation->setAdress('Adress'. rand(0,100));
			$organisation->setCity('City'. rand(0,100));
			$organisation->setCountry('Country'. rand(0,100));
			$organisation->setContactperson('Contact Person organisation'. rand(0,100));
			$organisation->setWebsite('Website'. rand(0,100));

			$this->addReference('Org_20', $organisation);

			$organisation->setCb($this->getReference('CB_12'));
			$manager->persist($organisation);

//		}

		$manager->flush();
	}

	private function loadCBS(ObjectManager $manager)
	{

			$cb  = new CB();
			$cb->setNumber(12);
			$cb->setName('CB'. rand(0,100));
		    $cb->setCity('City'. rand(0,100));
		    $cb->setAdress('Adress'. rand(0,100));
	     	$cb->setCountry('Country'. rand(0,100));
		    $cb->setContactperson('Contact person CB'. rand(0,100));
		    $cb->setWebsite('www.website.com'. rand(0,100));

		$this->addReference('CB_12', $cb);

		$manager->persist($cb);

		$manager->flush();
	}

	private function loadAudits(ObjectManager $manager)
	{
//		for ($i = 1; $i < 10; $i++) {
			$audit = new Audit();
			$audit->setTitle('Audit Title');
			$audit->setStatus('Status'. rand(0,100));
			$audit->setNumberfte( rand(0,100));
			$audit->setAudittype('Audit Type'. rand(0,100));
			$audit->setScopestatment('Audit Scope Statement'. rand(0,100));
			$audit->setAuditdfinding('Audit Finding'. rand(0,100));

			$audit->setOrg($this->getReference('Org_20'));
			$manager->persist($audit);
//		}

		$manager->flush();
	}


	private function loadUsers(ObjectManager $manager)
	{


		foreach (self::USERS as $userData)
		{
			$user = new User();
			$user->setUsername($userData['username']);
			$user->setName($userData['fullName']);
			$user->setEmail($userData['email']);
			$user->setPasswword(
				$this->passwordEncoder->encodePassword(
					$user,
					$userData['password']
				)
			);
			$user->setRoles($userData['roles']);
			$this->addReference($userData['username'],
				$user
			);

			$manager->persist($user);
			$manager->flush();
		}

	}


	private function loadAuditors(ObjectManager $manager)
	{

		$auditor = new Auditor();
		$auditor->setFirstname('auditor1');
		$auditor->setLastname('lastnameauditor1');
		$auditor->setEmail('auditor@l.com');
		$auditor->setGender('male');
		$auditor->setUsername('auditor1');
		$auditor->setPassword($this->passwordEncoder->encodePassword($auditor, 'auditor1'));

//		$auditor->setPassword('test');


		$manager->persist($auditor);
		$manager->flush();
	}

}
