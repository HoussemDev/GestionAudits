<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;


/**
 * @ORM\Entity(repositoryClass="App\Repository\CBRepository")
 */
class CB
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactperson;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Organisation", mappedBy="cb")
	 */
    private $organisations;

	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="usercb")
	 */
    private $cbuser;

	/**
	 * @return mixed
	 */
	public function getCbuser()
	{
		return $this->cbuser;
	}

    public function __construct()
	{
		$this->organisations = new ArrayCollection();
		$this->cbuser = new ArrayCollection();
	}

	public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function getSlug(): string
	{
		return(new Slugify())->slugify($this->name);
	}


    public function getAdress(): ?string
{
	return $this->adress;

}
    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getContactperson(): ?string
    {
        return $this->contactperson;
    }

    public function setContactperson(?string $contactperson): self
    {
        $this->contactperson = $contactperson;

        return $this;
    }

	/**
	 * @return mixed
	 */
	public function getOrganisations()
	{
		return $this->organisations;
	}

}
