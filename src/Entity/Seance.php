<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeanceRepository")
 */
class Seance
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le titre doit etre 10 caracteres min ")
     * @Assert\Length(min="10", minMessage="Le titre doit etre 10 caracteres min ")
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     *  
     */
    private $description;


    

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Realisation", inversedBy="seances")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="aucune Realisation ajoutée Par ce compte . vous douvez ajouter une Realisation")
     */
    private $realisation;

    /**
     * @ORM\Column(type="date")
     */
    private $temps;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $duree;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

 
    public function getRealisation(): ?Realisation
    {
        return $this->realisation;
    }

    public function setRealisation(?Realisation $realisation): self
    {
        $this->realisation = $realisation;

        return $this;
    }

    public function getTemps(): ?\DateTimeInterface
    {
        return $this->temps;
    }

    public function setTemps(\DateTimeInterface $temps): self
    {
        $this->temps = $temps;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }



}
