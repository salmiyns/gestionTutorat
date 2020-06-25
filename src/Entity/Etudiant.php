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
     * @ORM\Column(type="string", length=255,unique=true, nullable=true)
     */
    private $Matricule;

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     */
    private $filiere;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $niveau;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="etudiant", cascade={"persist", "remove"})
     */
    private $idUser;

    /**
     * @ORM\OneToOne(targetEntity=Tuteurr::class, mappedBy="etudiant", cascade={"persist", "remove"})
     */
    private $tuteurr;

    /**
     * @ORM\OneToOne(targetEntity=Tutoree::class, mappedBy="etudiant", cascade={"persist", "remove"})
     */
    private $tutoree;

 
    


    


    

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

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getTuteurr(): ?Tuteurr
    {
        return $this->tuteurr;
    }

    public function setTuteurr(?Tuteurr $tuteurr): self
    {
        $this->tuteurr = $tuteurr;

        // set (or unset) the owning side of the relation if necessary
        $newEtudiant = null === $tuteurr ? null : $this;
        if ($tuteurr->getEtudiant() !== $newEtudiant) {
            $tuteurr->setEtudiant($newEtudiant);
        }

        return $this;
    }

    public function getTutoree(): ?Tutoree
    {
        return $this->tutoree;
    }

    public function setTutoree(?Tutoree $tutoree): self
    {
        $this->tutoree = $tutoree;

        // set (or unset) the owning side of the relation if necessary
        $newEtudiant = null === $tutoree ? null : $this;
        if ($tutoree->getEtudiant() !== $newEtudiant) {
            $tutoree->setEtudiant($newEtudiant);
        }

        return $this;
    }

   
    
 
    

   

    
  
    

   
    
}
