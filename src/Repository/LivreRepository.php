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

}