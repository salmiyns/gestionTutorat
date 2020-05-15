<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InscriptionRepository")
 */
class Inscription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tutore", inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Tutore;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Realisation", inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Realisation;

    /**
     * @ORM\Column(type="date")
     */
    private $date_inscrption;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tutore", inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tutore;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Realisation", inversedBy="inscriptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $realisation;

    /**
     * @ORM\Column(type="integer")
     */
    private $statut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTutore(): ?Tutore
    {
        return $this->Tutore;
    }

    public function setTutore(?Tutore $Tutore): self
    {
        $this->Tutore = $Tutore;

        return $this;
    }

    public function getRealisation(): ?Realisation
    {
        return $this->Realisation;
    }

    public function setRealisation(?Realisation $Realisation): self
    {
        $this->Realisation = $Realisation;

        return $this;
    }

    public function getDateInscrption(): ?\DateTimeInterface
    {
        return $this->date_inscrption;
    }

    public function setDateInscrption(\DateTimeInterface $date_inscrption): self
    {
        $this->date_inscrption = $date_inscrption;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(int $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
