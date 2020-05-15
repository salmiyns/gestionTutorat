<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtudiantRepository")
 */
class Etudiant
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
    private $Matricule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filiere;

 
    

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Tuteur", mappedBy="IdEtudiant", cascade={"persist", "remove"})
     */
    private $tuteur;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Tutore", mappedBy="etudiant", cascade={"persist", "remove"})
     */
    private $tutore;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="etudiants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $UserId;


    


    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->Matricule;
    }

    public function setMatricule(string $Matricule): self
    {
        $this->Matricule = $Matricule;

        return $this;
    }

    public function getFiliere(): ?string
    {
        return $this->filiere;
    }

    public function setFiliere(string $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }

   
    
 
    

    public function getTuteur(): ?Tuteur
    {
        return $this->tuteur;
    }

    public function setTuteur(Tuteur $tuteur): self
    {
        $this->tuteur = $tuteur;

        // set the owning side of the relation if necessary
        if ($tuteur->getIdEtudiant() !== $this) {
            $tuteur->setIdEtudiant($this);
        }

        return $this;
    }

    public function getTutore(): ?Tutore
    {
        return $this->tutore;
    }

    public function setTutore(Tutore $tutore): self
    {
        $this->tutore = $tutore;

        // set the owning side of the relation if necessary
        if ($tutore->getEtudiant() !== $this) {
            $tutore->setEtudiant($this);
        }

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->UserId;
    }

    public function setUserId(?User $UserId): self
    {
        $this->UserId = $UserId;

        return $this;
    }

  
    

   
    
}
