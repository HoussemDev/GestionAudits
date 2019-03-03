<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CertificatRepository")
 */
class Certificat
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $scopestatment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $scope;

    /**
     * @ORM\Column(type="datetime")
     */
    private $issuedate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $validuntil;

    /**
     * @ORM\Column(type="string", length=255)
     */
//    private $date;
//
//    /**
//     * @ORM\Column(type="string", length=255)
//     */
    private $Certificatstatus;

    /**
     * @ORM\Column(type="datetime")
     */
    private $initialcertdate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
	public function getSlug(): string
	{
		return(new Slugify())->slugify($this->title);
	}


	public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getScopestatment(): ?string
    {
        return $this->scopestatment;
    }

    public function setScopestatment(string $scopestatment): self
    {
        $this->scopestatment = $scopestatment;

        return $this;
    }

    public function getScope(): ?string
    {
        return $this->scope;
    }

    public function setScope(string $scope): self
    {
        $this->scope = $scope;

        return $this;
    }

    public function getIssuedate(): ?\DateTimeInterface
    {
        return $this->issuedate;
    }

    public function setIssuedate(\DateTimeInterface $issuedate): self
    {
        $this->issuedate = $issuedate;

        return $this;
    }

    public function getValiduntil(): ?\DateTimeInterface
    {
        return $this->validuntil;
    }

    public function setValiduntil(\DateTimeInterface $validuntil): self
    {
        $this->validuntil = $validuntil;

        return $this;
    }

//    public function getDate(): ?string
//    {
//        return $this->date;
//    }
//
//    public function setDate(string $date): self
//    {
//        $this->date = $date;
//
//        return $this;
//    }

    public function getCertificatstatus(): ?string
    {
        return $this->Certificatstatus;
    }

    public function setCertificatstatus(string $Certificatstatus): self
    {
        $this->Certificatstatus = $Certificatstatus;

        return $this;
    }

    public function getInitialcertdate(): ?\DateTimeInterface
    {
        return $this->initialcertdate;
    }

    public function setInitialcertdate(\DateTimeInterface $initialcertdate): self
    {
        $this->initialcertdate = $initialcertdate;

        return $this;
    }
}
