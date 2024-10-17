<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivreController extends AbstractController
{
    #[Route('/livre', name: 'livres.create', methods: ['POST'])]

    function creerLivre(Request $req, LivreRepository $repository)
    {
        // Récuperer les données depuis la requête
        $titre = $req->request->get('titre');

        // Valider le titre
        if (!isset($titre) || $titre == "") {
            return $this->json(['erreur' => "Titre obligatoire !"]);
        }

        // Créer le livre
        $nouveauLivre = new Livre();
        $nouveauLivre->setTitre($titre);

        // Enregistrer le livre dans la bdd
        $livresave = $repository->save($nouveauLivre, true);

        return $this->json(['id' => $livresave->getId(), "titre" => $livresave->getTitre()]);
    }

    #[Route('/livre', name: 'livres.tout', methods: ['GET'])]
    // on injecte la dépendance dans les paramétres de la fonction pour cette fonction $repo est injecter dans LivreRepository
    function recuperetTousLivres(LivreRepository $repo)
    {
        $livres = $repo->findAll();

        $livreTableau = [];

        foreach ($livres as $livre) {
            $livreTableau[] = ['id' => $livre->getId(), 'titre' => $livre->getTitre()];
        }

        return $this->json($livreTableau);
    }

    #[Route('/livre/{id}', name: 'livres.id', methods: ['GET'])]
    function recupererLivre(LivreRepository $repo, $id)
    {
        // Récuperer le livre avec son Id
        $livre = $repo->find($id);
        // Si le livre n'existe pas on retourne 404
        if (!$livre) {
            return $this->json("le livre n'existe pas", Response::HTTP_NOT_FOUND);
        }

        // Retouner le livre récupérer
        return $this->json(['id' => $livre->getId(), 'titre' => $livre->getTitre()]);
    }

    #[Route('/livre/{id}', name: 'livres.update', methods: ['POST'])]

    function mettreAjourLivre($id, LivreRepository $repo, Request $req)
    {
        // Récuperer le livre avec son Id

        $livre = $repo->find($id);

        // Si le livre n'existe pas on retourne 404

        if (!$livre) {
            return $this->json("le livre n'existe pas", Response::HTTP_NOT_FOUND);
        }
        // RECUPERER LE TITRE DU CORP DE LA REQUETE
        $nouveauTitre = $req->request->get('titre');

        // VALDER LE NOUVEAU TITRE
        if (!isset($nouveauTitre) || $nouveauTitre == "") {

            return $this->json("Titre obligatoire", Response::HTTP_BAD_REQUEST);
        }
        // METTRE A JOUR LE LIVRE
        $livre->setTitre($nouveauTitre);

        // Enregistre le divre dans la BDD
        $repo->save($livre, true);

        return $this->json($livre->getTitre() . 'Livre mis à jour !');
    }

    #[Route('/livre/{id}', name: 'livres.supprimer', methods: ['DELETE'])]

    function supprimerLivre($id, LivreRepository $repo)
    {
        // Récupérer le livre avec on identifiant
        $livre = $repo->find($id);

        // Si le livre n'existe pas on retourne un 404
        if (!$livre) {
            return $this->json("le livre n'existe pas", Response::HTTP_NOT_FOUND);
        }

        // Supprmer le livre de la BDD
        $repo->supprimer($livre);

        // Retourner un message
        return $this->json("Livre supprimer");

    }
}
