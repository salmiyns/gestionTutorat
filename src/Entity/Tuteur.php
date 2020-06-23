<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Exception\RetryableException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TuteurRepository")
 */
class Tuteur   
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Etudiant", inversedBy="tuteur", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $IdEtudiant;

 

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Realisation", mappedBy="tuteur", orphanRemoval=true)
     */
    private $realisations;

    /**
     * @ORM\OneToMany(targetEntity=Proposition::class, mappedBy="tuteur")
     */
    private $proposi;

    public function __construct()
    {
         $this->realisations = new ArrayCollection();
        $this->proposi = new ArrayCollection();
    }

    


    


    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEtudiant(): ?Etudiant
    {
        return $this->IdEtudiant;
    }

    public function setIdEtudiant(Etudiant $IdEtudiant): self
    {
        $this->IdEtudiant = $IdEtudiant;

        return $this;
    }


 
 

    public function __toString() 
        {
            return (string) $this->id; 
        }

    /**
     * @return Collection|Realisation[]
     */
    public function getRealisations(): Collection
    {
        return $this->realisations;
    }

    public function addRealisation(Realisation $realisation): self
    {
        if (!$this->realisations->contains($realisation)) {
            $this->realisations[] = $realisation;
            $realisation->setTuteur($this);
        }

        return $this;
    }

    public function removeRealisation(Realisation $realisation): self
    {
        if ($this->realisations->contains($realisation)) {
            $this->realisations->removeElement($realisation);
            // set the owning side to null (unless already changed)
            if ($realisation->getTuteur() === $this) {
                $realisation->setTuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Proposition[]
     */
    public function getProposi(): Collection
    {
        return $this->proposi;
    }

    public function addProposi(Proposition $proposi): self
    {
        if (!$this->proposi->contains($proposi)) {
            $this->proposi[] = $proposi;
            $proposi->setTuteur($this);
        }

        return $this;
    }

    public function removeProposi(Proposition $proposi): self
    {
        if ($this->proposi->contains($proposi)) {
            $this->proposi->removeElement($proposi);
            // set the owning side to null (unless already changed)
            if ($proposi->getTuteur() === $this) {
                $proposi->setTuteur(null);
            }
        }

        return $this;
    }
        
    


    
}
