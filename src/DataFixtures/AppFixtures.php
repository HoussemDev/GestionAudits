<?php

namespace App\DataFixtures;

use App\Entity\Audit;
use App\Entity\CB;
use App\Entity\Organisation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);



		$this->loadCBS($manager);
		$this->loadOrganisations($manager);
		$this->loadAudits($manager);
    }

	private function loadOrganisations(ObjectManager $manager)
	{
		for ($i = 1; $i < 10; $i++) {
			$organisation = new Organisation();
			$organisation->setNumber($i);
			$organisation->setName('Organisation'. rand(0,100));
			$organisation->setAdress('Adress'. rand(0,100));
			$organisation->setCity('City'. rand(0,100));
			$organisation->setCountry('Country'. rand(0,100));
			$organisation->setContactperson('Contact Person organisation'. rand(0,100));
			$organisation->setWebsite('Website'. rand(0,100));

			$this->addReference('Org_10', $organisation);

			$organisation->setCb($this->getReference('CB_12'));
			$manager->persist($organisation);

		}

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
		for ($i = 1; $i < 10; $i++) {
			$audit = new Audit();
			$audit->setTitle('Audit Title'. $i);
			$audit->setStatus('Status'. rand(0,100));
			$audit->setNumberfte( rand(0,100));
			$audit->setAudittype('Audit Type'. rand(0,100));
			$audit->setScopestatment('Audit Scope Statement'. rand(0,100));
			$audit->setAuditdfinding('Audit Finding'. rand(0,100));

			$audit->setCb($this->getReference('Org_10'));
			$manager->persist($audit);
		}

		$manager->flush();
	}
}
