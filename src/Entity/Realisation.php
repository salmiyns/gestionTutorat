<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RealisationRepository")
 */
class Realisation
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
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $desicription;

    /**
     * @ORM\Column(type="date")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="date")
     */
    private $date_modification;
 

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cours", inversedBy="realisations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cours;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Seance", mappedBy="realisation", orphanRemoval=true)
     */
    private $seances;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Inscription", mappedBy="realisation", orphanRemoval=true)
     */
    private $inscriptions;

   
    /**
     * @ORM\Column(type="date")
     */
    private $date_fin;

    /**
     * @ORM\ManyToOne(targetEntity=Tuteurr::class, inversedBy="realisations")
     */
    private $tuteur;

    public function __construct()
    {
        $this->seances = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
    }

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

    public function getDesicription(): ?string
    {
        return $this->desicription;
    }

    public function setDesicription(?string $desicription): self
    {
        $this->desicription = $desicription;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->date_modification;
    }

    public function setDateModification(\DateTimeInterface $date_modification): self
    {
        $this->date_modification = $date_modification;

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

    /**
     * @return Collection|Seance[]
     */
    public function getSeances(): Collection
    {
        return $this->seances;
    }

    public function addSeance(Seance $seance): self
    {
        if (!$this->seances->contains($seance)) {
            $this->seances[] = $seance;
            $seance->setRealisation($this);
        }

        return $this;
    }

    public function removeSeance(Seance $seance): self
    {
        if ($this->seances->contains($seance)) {
            $this->seances->removeElement($seance);
            // set the owning side to null (unless already changed)
            if ($seance->getRealisation() === $this) {
                $seance->setRealisation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Inscription[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setRealisation($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->contains($inscription)) {
            $this->inscriptions->removeElement($inscription);
            // set the owning side to null (unless already changed)
            if ($inscription->getRealisation() === $this) {
                $inscription->setRealisation(null);
            }
        }

        return $this;
    }

   
    

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function __toString()
    {
        return  $this->getTitre();
    }

    public function getTuteur(): ?Tuteurr
    {
        return $this->tuteur;
    }

    public function setTuteur(?Tuteurr $tuteur): self
    {
        $this->tuteur = $tuteur;

        return $this;
    }
   

}
