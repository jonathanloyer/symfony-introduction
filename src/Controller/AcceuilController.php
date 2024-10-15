<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilController
{
    #[Route("/", name: "acceuil", methods: ["GET"])]

    function acceuil()
    {
        return new Response("<h1>Salut tous le monde</h1>", Response::HTTP_OK);
    }


    #[Route("/inscription", name: "inscription", methods: ['POST'])]

    function inscription(Request $request)

    {
        
        return new Response(
            $request->request->get("email"),       
             Response::HTTP_OK);
    }

    #[Route("/connexion", name: "connexion", methods: ['POST'])]

    function connection(Request $request)

    {
        var_dump($request);
        
        return new Response(
            $request->request->get("nom" . "prenom" . "email" . "mdp"),       
             Response::HTTP_OK);
    }

    // Route dynamique avec paramètre
    #[Route("/salut/{nom}", name: "bonjour", methods: ["GET"])]
    function bonjour($nom)
    {
        return new Response("<h1>Salut $nom</h1>", Response::HTTP_OK);
    }
}
