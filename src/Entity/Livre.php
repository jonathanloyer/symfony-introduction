<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Orm\Mapping as Orm;

#[ORM\Entity(repositoryClass: LivreRepository::class)]

class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]

    private ?int $id = null;

    #[ORM\Column(length:255)]
    
    private ?string $titre = null;

   
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
   

    /**
     * @return string|null
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    /**
     * Set the value of titre
     *
     * @return  self
     */ 
    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }
}