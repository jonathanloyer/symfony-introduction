<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NumberController


{
    #[Route("/aleatoire", name: "aleatoire", methods: ["GET"])]

    function number()
    {


        $nombreAleatoire = mt_rand(0, 1000);

        return new Response("<h2>le nombre est : $nombreAleatoire</h2", Response::HTTP_OK);
    }

    // Exercice:
    // Créer une action dans NombreController avec un route dynamique /add/1/2 qui reçoit deux nombre et retourne la somme des deux nom}res.
    #[Route("/addition/{num1}/{num2}", name: "addition", methods: ["GET"])]
    public function addController(int $num1, int $num2)
    {
        if(!is_numeric($num1) || !is_numeric($num2)) {
            return new Response("<h2>Nombre incorrect</h2", Response::HTTP_OK);
        }
        $sum = $num1 + $num2;
        return new Response("La somme de $num1 et $num2 est : $sum");
    }
}


