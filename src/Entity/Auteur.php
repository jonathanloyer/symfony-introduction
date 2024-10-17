<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuteurRepository::class)]

class Auteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]

    private ?int $id = null;

    #[ORM\Column(length: 255)]

    private ?string $nom = null;

    #[ORM\Column(length: 255)]

    private ?string $prenom = null;

    #[ORM\Column]

    private ?int $date = null;

    #[ORM\OneToMany(
        targetEntity:"App\Entity\Livre",
        mappedBy:"auteur",
        cascade:['persist','remove']
    )]
    private $livres;

        function __construct()
        {
            $this->livres = new ArrayCollection();            
        }

        
        public function getLivres():Collection
        {
            return $this->livres;
        }
        function addLivre(Livre $livre)
        {
            $livre ->setAuteur($this);
            $this->livres->add($livre);
        }

    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    
    /**
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom(?string $nom):self
    {
        $this->nom = $nom;

        return $this;
    }

   
    /**
     * @return string|null
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

   
    
    /**
     * @return int|null
     */
    public function getDate(): ?int
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate(?int $date):self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of livres
     */ 
}