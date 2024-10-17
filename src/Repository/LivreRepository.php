<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class LivreRepository extends ServiceEntityRepository

{
    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct($doctrine, Livre::class);
    }

    public function save( Livre $nouveauLivre, ?bool $flush = false) 
    {
        $this->getEntityManager()->persist($nouveauLivre);

        if($flush){
            $this->getEntityManager()->flush();
        }
        return $nouveauLivre;

    }
    
    function supprimer(Livre $livre)
    {
        $this->getEntityManager()->remove($livre);
        $this->getEntityManager()->flush();
    }

}