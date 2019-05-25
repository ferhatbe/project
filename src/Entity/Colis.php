<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ColisRepository")
 */
class Colis
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    // la variable qui reference vers le id du createur
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $paysDepart;

    /**
 * @ORM\Column(type="string", length=255)
 */
    private $paysArrive;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $villeDepart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $villeArrive;

    /**
     * @ORM\Column(type="date")
     * @Assert\LessThanOrEqual("now")
     */
    private $dateDep;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $poids;

    // les case a cocher avant d'ajouter une annonce
    public $medicament;
    public $objets;
    public $cgu;

    /**
     * @return mixed
     */
    public function getCgu()
    {
        return $this->cgu;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPaysDepart(): ?string
    {
        return $this->paysDepart;
    }

    public function setPaysDepart(string $paysDepart): self
    {
        $this->paysDepart = $paysDepart;

        return $this;
    }

    public function getPaysArrive(): ?string
    {
        return $this->paysArrive;
    }

    public function setPaysArrive(string $paysArrive): self
    {
        $this->paysArrive = $paysArrive;

        return $this;
    }

    public function getVilleDepart(): ?string
    {
        return $this->villeDepart;
    }

    public function setVilleDepart(string $villeDepart): self
    {
        $this->villeDepart = $villeDepart;

        return $this;
    }

    public function getVilleArrive(): ?string
    {
        return $this->villeArrive;
    }

    public function setVilleArrive(string $villeArrive): self
    {
        $this->villeArrive = $villeArrive;

        return $this;
    }

    public function getDateDep(): ?\DateTimeInterface
    {
        return $this->dateDep;
    }

    public function setDateDep(\DateTimeInterface $dateDep): self
    {
        $this->dateDep = $dateDep;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMedicament()
    {
        return $this->medicament;
    }


    /**
     * @return mixed
     */
    public function getObjets()
    {
        return $this->objets;
    }


}
