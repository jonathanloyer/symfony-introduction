<?php

namespace App\Repository;

use App\Entity\Auteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

// use App\Enity\Auteur;

class AuteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct($doctrine, Auteur::class);
    }
    
    public function sauvegarder(Auteur $nouveauAuteur, ?bool $flush = false)
    {
        $this->getEntityManager()->persist($nouveauAuteur);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $nouveauAuteur;
    }
    function supprimer(Auteur $auteur)
    {
        $this->getEntityManager()->remove($auteur);
        $this->getEntityManager()->flush();
    }
}
