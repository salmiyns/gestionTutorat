<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DemandeRepository")
 */
class Demande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tutore", inversedBy="demandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tutore;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cours", inversedBy="demandes")
     * @ORM\JoinColumn(nullable=false)
     * cascade={"persist"}
     */
    private $cours;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTutore(): ?Tutore
    {
        return $this->tutore;
    }

    public function setTutore(?Tutore $tutore): self
    {
        $this->tutore = $tutore;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        $this->cours = $cours;

        return $this;
    }
}
