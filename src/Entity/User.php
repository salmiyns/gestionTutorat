<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Expr\Cast\String_;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Serializable;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;



/**
     * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
     * @ORM\Table(name="`user`")
     * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
     * @Vich\Uploadable

     */
    class User implements UserInterface, Serializable
      { 
          /**
           * @ORM\Id()
           * @ORM\GeneratedValue()
           * @ORM\Column(type="integer")
           */
          private $id;
      
          /**
           * @ORM\Column(type="string", length=180, unique=true)
           * @Assert\NotBlank(message="Ajoutez une valide adresse email")
           * */
          private $email;
      
          /**
           * @ORM\Column(type="json")
           */
          private $roles = [];
      
          /**
           * @var string The hashed password
           * @ORM\Column(type="string")
          */
          private $password;
      
          /**
           * @ORM\Column(type="string", length=255, nullable=false)
           * @Assert\NotBlank(message="insérez un prénom")
           */
          private $firstName;
      
          /**
           * @ORM\Column(type="string", length=255, nullable=false)
           * @Assert\NotBlank(message="insérez un nom")
           */
          private $lastName;
      
          /**
           * @ORM\Column(type="date", length=255,nullable=true)
           */
          private $date_of_birth;
      
          /**
           * @ORM\Column(type="string", length=255, nullable=true)
           */
          private $image;

          /**
         * @Vich\UploadableField(mapping="user_images", fileNameProperty="image")
         * @var File
         */
         private $imageFile;
          /**
           * @ORM\Column(type="string", length=255, nullable=true)
            * @Assert\NotBlank(message="Please provide a number")
            * @Assert\Length(
            *     min=8,
            *     max=12,
            *     minMessage="numero tephone doit contenir au moins 8 chiffrer",
            *     maxMessage="numero tephone  doit contenir au maximum 12 chiffres"
            * )
            * @Assert\Regex(
            *     pattern="/^[0-9]+$/",
            *     message="Seuls les numéros sont autorisés"
            * )
           */
          private $telephone;
      
          /**
           * @ORM\Column(type="string", length=255 ,nullable=true)
           */
          private $sexe;
      
          /**
           * @ORM\Column(type="string", length=255, nullable=true)
           */
          private $adresse;
      
          /**
           * @ORM\Column(type="text", nullable=true)
           */
          private $about;

 


         /**
         * @ORM\Column(type="boolean")
         */
        private $isActive = false;

        /**
         * @ORM\Column(type="datetime", nullable=true)
         */
        private $createdAt;

        /**
         *  @ORM\Column(type="datetime", nullable=true)
         */
        private $updatedAt;

        /**
         * @ORM\Column(type="datetime", nullable=true)
         */

         /**
         * @ORM\Column(type="datetime", nullable=true)
         */
        private $activatedAt;

        /**
         * @ORM\Column(type="boolean")
         */
        private $isVerified ;



        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $activation_token;

        /**
         * @ORM\Column(type="string", length=255, nullable=true)
         */
        private $reset_token;

        /**
         * @ORM\OneToOne(targetEntity=Etudiant::class, mappedBy="idUser", cascade={"persist", "remove"})
         */
        private $etudiant;

        /**
         * @ORM\OneToOne(targetEntity=Enseignant::class, mappedBy="idUser", cascade={"persist", "remove"})
         */
        private $enseignant;
      

        
       
          public function getId(): ?int
          {
              return $this->id;
          }
      
          public function getEmail(): ?string
          {
              return $this->email;
          }
      
          public function setEmail(string $email): self
          {
              $this->email = $email;
      
              return $this;
          }
      
          /**
           * A visual identifier that represents this user.
           *
           * @see UserInterface
           */
          public function getUsername(): string
          {
              return (string) $this->email;
          }
      
          /**
           * @see UserInterface
           */
          public function getRoles(): array
          {
              $roles = $this->roles;
              // guarantee every user at least has ROLE_USER
              $roles[] = 'ROLE_TUTORE';
      
              return array_unique($roles);
          }
      
          public function setRoles(array $roles): self
          {
              $this->roles = $roles;
      
              return $this;
          }
      
          /**
           * @see UserInterface
           */
          public function getPassword(): string
          {
              return (string) $this->password;
          }
      
          public function setPassword(string $password): self
          {
              $this->password = $password;
      
              return $this;
          }
      
          /**
           * @see UserInterface
           */
          public function getSalt()
          {
              // not needed when using the "bcrypt" algorithm in security.yaml
          }
      
          /**
           * @see UserInterface
           */
          public function eraseCredentials()
          {
              // If you store any temporary, sensitive data on the user, clear it here
              // $this->plainPassword = null;
          }
      
          public function getFirstName(): ?string
          {
              return $this->firstName;
          }
      
          public function setFirstName(?string $firstName): self
          {
              $this->firstName = $firstName;
      
              return $this;
          }
      
          public function getLastName(): ?string
          {
              return $this->lastName;
          }
      
          public function setLastName(?string $lastName): self
          {
              $this->lastName = $lastName;
      
              return $this;
          }
      
          public function getDateOfBirth(): ?\DateTime
          {
              return $this->date_of_birth;
          }
      
          public function setDateOfBirth(?\DateTime $date_of_birth): self
          {
              $this->date_of_birth = $date_of_birth;
      
              return $this;
          }
     
          
          
          
      
      
      
          public function getAvatarUrl(string $ext = null): string
          {
              $url = 'https://avatars.dicebear.com/v2/initials/'.$this->getFirstName()."%20".$this->getlastName();
      
              
              if ($ext) {
                  $url .= sprintf('.'.$ext);
              }
      
              return $url;
          }
         
          
          
          public function getTelephone(): ?string
          {
              return $this->telephone;
          }
      
          public function setTelephone(?string $telephone): self
          {
              $this->telephone = $telephone;
      
              return $this;
          }
      
          public function getSexe(): ?string
          {
              return $this->sexe;
          }
      
          public function setSexe(string $sexe): self
          {
              $this->sexe = $sexe;
      
              return $this;
          }
      
          public function getAdresse(): ?string
          {
              return $this->adresse;
          }
      
          public function setAdresse(?string $adresse): self
          {
              $this->adresse = $adresse;
      
              return $this;
          }
      
          public function getAbout(): ?string
          {
              return $this->about;
          }
      
          public function setAbout(?string $about): self
          {
              $this->about = $about;
      
              return $this;
          }


          public function getCreatedAt(): ?DateTime
          {
              return $this->createdAt;
          }
      
          public function setCreatedAt(?DateTime $createdAt): self
          {
              $this->createdAt = $createdAt;
      
              return $this;
          }


           



          public function getUpdatedAt(): ?DateTime
          {
              return $this->updatedAt;
          }
      
          public function setUpdatedAt(?DateTime $updatedAt): self
          {
              $this->updatedAt = $updatedAt;
      
              return $this;
          }



 
          public function getActivatedAt(): ?DateTime
          {
            return $this->activatedAt;
          }
      
    
        public function setActivatedAt(?DateTime $activatedAt): self
        {
            $this->activatedAt = $activatedAt;
            return $this;
        }



      
        public function isActive()
        {
            return $this->isActive;
        }

      
        public function setIsActive($isActive): void
        {
            $this->isActive = $isActive;
        }
      
         


        /** @see \Serializable::serialize() */
        public function serialize()
        {
            return serialize(array(
                $this->id,
                $this->email,
               // $this->name,
                $this->isActive,
                $this->password,
                $this->image,
                $this->imageFile = base64_encode($this->imageFile)

            


            ));
        }
    
        /** @see \Serializable::unserialize() */
        public function unserialize($serialized)
        {
            list (
                $this->id,
                $this->email,
               // $this->name,
                $this->isActive,
                $this->password,
                $this->image,
               
                ) = unserialize($serialized);
        }

        public function isVerified(): bool
        {
            return $this->isVerified;
        }

        public function setVerified($isVerified): void
        {
            $this->isVerified = $isVerified;
        }
      
      
        public function getActivationToken(): ?string
        {
            return $this->activation_token;
        }

        public function setActivationToken(?string $activation_token): self
        {
            $this->activation_token = $activation_token;

            return $this;
        }

        public function getResetToken(): ?string
        {
            return $this->reset_token;
        }

        public function setResetToken(?string $reset_token): self
        {
            $this->reset_token = $reset_token;

            return $this;
        }

        public function getEtudiant(): ?Etudiant
        {
            return $this->etudiant;
        }

        public function setEtudiant(?Etudiant $etudiant): self
        {
            $this->etudiant = $etudiant;

            // set (or unset) the owning side of the relation if necessary
            $newIdUser = null === $etudiant ? null : $this;
            if ($etudiant->getIdUser() !== $newIdUser) {
                $etudiant->setIdUser($newIdUser);
            }

            return $this;
        }

        public function getEnseignant(): ?Enseignant
        {
            return $this->enseignant;
        }

        public function setEnseignant(?Enseignant $enseignant): self
        {
            $this->enseignant = $enseignant;

            // set (or unset) the owning side of the relation if necessary
            $newIdUser = null === $enseignant ? null : $this;
            if ($enseignant->getIdUser() !== $newIdUser) {
                $enseignant->setIdUser($newIdUser);
            }

            return $this;
        }
            
        public function __toString()
        {
            return  $this->email;
        }
      
        
        public function setImageFile(File $image = null)
        {
            $this->imageFile = $image;
    
            // VERY IMPORTANT:
            // It is required that at least one field changes if you are using Doctrine,
            // otherwise the event listeners won't be called and the file is lost
            if ($image) {
                // if 'updatedAt' is not defined in your entity, use another property
                $this->updatedAt = new \DateTime('now');
            }
        }


        public function getImageFile()
        {
            return $this->imageFile;
        }

 
        public function setImage($image)
        {
            $this->image = $image;
        }

        public function getImage()
        {
            return $this->image;
        }
          
      }
