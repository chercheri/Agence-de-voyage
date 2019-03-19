<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgrammationCircuitRepository")
 */
class ProgrammationCircuit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDepart;

    /**
     * @ORM\Column(type="smallint")
     */
    private $nombrePersonnes;

    /**
     * @ORM\Column(type="smallint")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Circuit", inversedBy="programmationCircuits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $circuit;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Res", mappedBy="ProgrammationCircuit")
     */
    private $res;

    public function __construct()
    {
        $this->res = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTimeInterface $dateDepart): self
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getNombrePersonnes(): ?int
    {
        return $this->nombrePersonnes;
    }

    public function setNombrePersonnes(int $nombrePersonnes): self
    {
        $this->nombrePersonnes = $nombrePersonnes;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCircuit(): ?Circuit
    {
        return $this->circuit;
    }

    public function setCircuit(?Circuit $circuit): self
    {
        $this->circuit = $circuit;

        return $this;
    }

   

    /**
     * @return Collection|Res[]
     */
    public function getRes(): Collection
    {
        return $this->res;
    }

    public function addRe(Res $re): self
    {
        if (!$this->res->contains($re)) {
            $this->res[] = $re;
            $re->setProgCir($this);
        }

        return $this;
    }

    public function removeRe(Res $re): self
    {
        if ($this->res->contains($re)) {
            $this->res->removeElement($re);
            // set the owning side to null (unless already changed)
            if ($re->getProgCir() === $this) {
                $re->setProgCir(null);
            }
        }

        return $this;
    }
}
