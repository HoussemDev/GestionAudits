<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 01/06/2019
 * Time: 14:18
 */

namespace App\Entity;


class OrganisationSearch
{
	/**
	 * @return null|string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param null|string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return null|string
	 */
	public function getCbname()
	{
		return $this->cbname;
	}

	/**
	 * @param null|string $cbname
	 */
	public function setCbname($cbname)
	{
		$this->cbname = $cbname;
	}

	/**
	 * @return null|string
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @param null|string $country
	 */
	public function setCountry($country)
	{
		$this->country = $country;
	}

	/**
	 * @var string|null
	 */

	private $name;

	/**
	 * @var string|null
	 */

	private $cbname;


	/**
	 * @var string|null
	 */

	private $country;


}