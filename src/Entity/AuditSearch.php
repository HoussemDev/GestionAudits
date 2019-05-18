<?php
/**
 * Created by PhpStorm.
 * User: Sony
 * Date: 14/05/2019
 * Time: 23:19
 */

namespace App\Entity;


class AuditSearch
{
	/**
	 * @var string|null
	 */
	private $audittitle;

	/**
	 * @return null|string
	 */
	public function getAudittitle()
	{
		return $this->audittitle;
	}

	/**
	 * @param null|string $audittitle
	 * @return AuditSearch
	 */
	public function setAudittitle($audittitle)
	{
		$this->audittitle = $audittitle;
		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getAuditstandard()
	{
		return $this->auditstandard;
	}

	/**
	 * @param null|string $auditstandard
	 * @return AuditSearch
	 */
	public function setAuditstandard($auditstandard)
	{
		$this->auditstandard = $auditstandard;
		return $this;
	}


	/**
	 * @var string|null
	 */
	private $auditstandard;


}