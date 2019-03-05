<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuditRepository")
 */
class Audit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Numberfte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $audittype;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $scopestatment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $auditdfinding;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Organisation", inversedBy="orgaudits")
	 * @ORM\JoinColumn()
	 */
	private $auditorg;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

	public function getSlug(): string
	{
		return(new Slugify())->slugify($this->Title);
	}

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): self
    {
        $this->Status = $Status;

        return $this;
    }

    public function getNumberfte(): ?int
    {
        return $this->Numberfte;
    }

    public function setNumberfte(?int $Numberfte): self
    {
        $this->Numberfte = $Numberfte;

        return $this;
    }

    public function getAudittype(): ?string
    {
        return $this->audittype;
    }

    public function setAudittype(?string $audittype): self
    {
        $this->audittype = $audittype;

        return $this;
    }

    public function getScopestatment(): ?string
    {
        return $this->scopestatment;
    }

    public function setScopestatment(?string $scopestatment): self
    {
        $this->scopestatment = $scopestatment;

        return $this;
    }

    public function getAuditdfinding(): ?string
    {
        return $this->auditdfinding;
    }

    public function setAuditdfinding(?string $auditdfinding): self
    {
        $this->auditdfinding = $auditdfinding;

        return $this;
    }
}
