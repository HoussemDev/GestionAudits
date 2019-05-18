<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 15/05/2019
 * Time: 22:20
 */

namespace App\Entity;


class UserSearch
{

	/**
	 * @var string|null
	 */
	private $username;

	/**
	 * @return null|string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param null|string $username
	 * @return UserSearch
	 */
	public function setUsername($username)
	{
		$this->username = $username;
		return $this;
	}

}