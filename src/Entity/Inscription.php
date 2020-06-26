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
     * @ORM\Column(type="date")
     */
    private $date_inscrption;

 
   
    /**
     * @ORM\Column(type="integer")
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Realisation::class, inversedBy="inscriptions")
     */
    private $realisation;

    /**
     * @ORM\ManyToOne(targetEntity=Tutoree::class, inversedBy="inscriptions")
     */
    private $tutore;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRealisation(): ?Realisation
    {
        return $this->realisation;
    }

    public function setRealisation(?Realisation $realisation): self
    {
        $this->realisation = $realisation;

        return $this;
    }

    public function getTutore(): ?Tutoree
    {
        return $this->tutore;
    }

    public function setTutore(?Tutoree $tutore): self
    {
        $this->tutore = $tutore;

        return $this;
    }
}
