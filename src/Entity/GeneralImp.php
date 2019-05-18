<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;


/**
 * @ORM\Entity(repositoryClass="App\Repository\GeneralImpRepository")
 */
class GeneralImp
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $capabilitymanagementsystem;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $contextorganisation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $leadership;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $planning;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $support;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $operation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $haccpplancomment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $haccpplanprocess;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $opportunityimprovement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titlegeneralimp;

    public function getId(): ?int
    {
        return $this->id;
    }

	public function getSlug(): string
	{
		return(new Slugify())->slugify($this->titlegeneralimp);
	}

    public function getCapabilitymanagementsystem(): ?string
    {
        return $this->capabilitymanagementsystem;
    }

    public function setCapabilitymanagementsystem(?string $capabilitymanagementsystem): self
    {
        $this->capabilitymanagementsystem = $capabilitymanagementsystem;

        return $this;
    }

    public function getContextorganisation(): ?string
    {
        return $this->contextorganisation;
    }

    public function setContextorganisation(?string $contextorganisation): self
    {
        $this->contextorganisation = $contextorganisation;

        return $this;
    }

    public function getLeadership(): ?string
    {
        return $this->leadership;
    }

    public function setLeadership(?string $leadership): self
    {
        $this->leadership = $leadership;

        return $this;
    }

    public function getPlanning(): ?string
    {
        return $this->planning;
    }

    public function setPlanning(?string $planning): self
    {
        $this->planning = $planning;

        return $this;
    }

    public function getSupport(): ?string
    {
        return $this->support;
    }

    public function setSupport(?string $support): self
    {
        $this->support = $support;

        return $this;
    }

    public function getOperation(): ?string
    {
        return $this->operation;
    }

    public function setOperation(?string $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

    public function getHaccpplancomment(): ?string
    {
        return $this->haccpplancomment;
    }

    public function setHaccpplancomment(?string $haccpplancomment): self
    {
        $this->haccpplancomment = $haccpplancomment;

        return $this;
    }

    public function getHaccpplanprocess(): ?string
    {
        return $this->haccpplanprocess;
    }

    public function setHaccpplanprocess(?string $haccpplanprocess): self
    {
        $this->haccpplanprocess = $haccpplanprocess;

        return $this;
    }

    public function getOpportunityimprovement(): ?string
    {
        return $this->opportunityimprovement;
    }

    public function setOpportunityimprovement(?string $opportunityimprovement): self
    {
        $this->opportunityimprovement = $opportunityimprovement;

        return $this;
    }

    public function getTitlegeneralimp(): ?string
    {
        return $this->titlegeneralimp;
    }

    public function setTitlegeneralimp(string $titlegeneralimp): self
    {
        $this->titlegeneralimp = $titlegeneralimp;

        return $this;
    }
}
