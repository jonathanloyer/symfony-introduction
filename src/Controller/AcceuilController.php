<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
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
            Response::HTTP_OK
        );
    }
    
    // Route dynamique avec paramètre
    #[Route("/salut/{nom}", name: "bonjour", methods: ["GET"])]
    function bonjour($nom)
    {
        return new Response("<h1>Salut $nom</h1>", Response::HTTP_OK);
    }


    #[Route("/connexion", name: "connexion", methods: ['POST'])]
    
    function connexion(Request $request)
    
    {
        // pour récupérer les donné d'un formulaire on utilse get()

        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $mdp = $request->request->get('mdp');
    
        if (!isset($email) || !isset($prenom) || !isset($nom) || !isset($mdp)) {
            return new Response("Donnée obligatoire", Response::HTTP_BAD_REQUEST);
        }
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new Response("Email invalide", Response::HTTP_BAD_REQUEST);
        }
    
        if ($nom == "" || $prenom == "") {
            return new Response("Nom et Prénom obligatoire", Response::HTTP_BAD_REQUEST);
        }
    
        if (strlen($mdp) < 6) {
            return new Response("Le mot de passe dois être supérieur a 6 caractères", Response::HTTP_BAD_REQUEST);
        }
    
    
        return new Response($email . " " . $prenom . " " . $nom . " ");
    }
    #[Route("/profile", name: "profile", methods: ['POST'])]

    function profile(Request $req)
    {
        // Dans de cas concret on récupérer les données de l'utilisateur depuis la base de donnée

        // Récuperer l'identifiant depuis le query de l'URL
        
        $id = $req->query->get('id');


    return new JsonResponse([

        "email" => "sam@sam.com",
        "prenom" => "sam",
        "identifiant" => $id
    ]);
        
    }
    

}
