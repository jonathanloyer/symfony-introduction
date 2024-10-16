<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LivreController extends AbstractController
{
    #[Route('/livre', name:'livres.create', methods:['POST'])]

    function creerLivre(Request $req, LivreRepository $repository)
    {
        // Récuperer les données depuis la requête
        $titre = $req->request->get('titre');

        // Valider le titre
        if(!isset($titre) || $titre ==""){
            return $this->json(['erreur'=>"Titre obligatoire !"]);
        }

        // Créer le livre
        $nouveauLivre = new Livre();
        $nouveauLivre->setTitre($titre);

        // Enregistrer le livre dans la bdd
        $livresave = $repository->save($nouveauLivre, true);

        return $this->json(['id' => $livresave->getId(), "titre" => $livresave->getTitre()]);
    }
    #[Route('/livre', name:'livres.tout', methods:['GET'])]
    function recuperetTousLivres(LivreRepository $repo)
    {
        $livres = $repo->findAll();
        $livreTableau = [];
        foreach($livres as $livre) {
            $livreTableau[] = ['id' => $livre->getId(), 'titre' => $livre->getTitre()];
        }
        return $this->json($livreTableau);
    }

}