<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;


/**
 * @ORM\Entity(repositoryClass="App\Repository\FindingRepository")
 */
class Finding
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $standard;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interpretation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $clause;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $causeanalysis;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $plannedcorrectiveaction;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $timescheduleforaction;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Audit", inversedBy="findings")
	 */
	private $auditInFinding;

	/**
	 * @return mixed
	 */
	public function getAuditInFinding()
	{
		return $this->auditInFinding;
	}

	/**
	 * @param mixed $auditInFinding
	 */
	public function setAuditInFinding($auditInFinding)
	{
		$this->auditInFinding = $auditInFinding;
	}

	public function getSlug(): string
	{
		return(new Slugify())->slugify($this->title);
	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStandard(): ?string
    {
        return $this->standard;
    }

    public function setStandard(?string $standard): self
    {
        $this->standard = $standard;

        return $this;
    }

    public function getInterpretation(): ?string
    {
        return $this->interpretation;
    }

    public function setInterpretation(?string $interpretation): self
    {
        $this->interpretation = $interpretation;

        return $this;
    }

    public function getClause(): ?string
    {
        return $this->clause;
    }

    public function setClause(?string $clause): self
    {
        $this->clause = $clause;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCauseanalysis(): ?string
    {
        return $this->causeanalysis;
    }

    public function setCauseanalysis(?string $causeanalysis): self
    {
        $this->causeanalysis = $causeanalysis;

        return $this;
    }

    public function getPlannedcorrectiveaction(): ?string
    {
        return $this->plannedcorrectiveaction;
    }

    public function setPlannedcorrectiveaction(?string $plannedcorrectiveaction): self
    {
        $this->plannedcorrectiveaction = $plannedcorrectiveaction;

        return $this;
    }

    public function getTimescheduleforaction(): ?string
    {
        return $this->timescheduleforaction;
    }

    public function setTimescheduleforaction(?string $timescheduleforaction): self
    {
        $this->timescheduleforaction = $timescheduleforaction;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
