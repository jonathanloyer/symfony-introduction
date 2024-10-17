<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Livre;
use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuteurController extends AbstractController
{
    #[Route("/auteur", name: "auteur.create", methods: ["POST"])]
    function creerLivre(Request $req, AuteurRepository $repository)
    {
        // Récuperer les données depuis la requete
        $nom = $req->request->get('nom');
        $prenom = $req->request->get('prenom');
        $date = $req->request->get('date');

        // Valider l'auteur
        if (!isset($nom) || $nom == "" || !isset($prenom) || $prenom == "" || !isset($date) || $date == "") {
            return $this->json(['erreur' => "Données obligatoires !"]);
        }

        // Créer l'auteur
        $nouveauAuteur = new Auteur();
        $nouveauAuteur->setNom($nom)->setPrenom($prenom)->setDate($date);

        // Enregistrer l'auteur dans la BDD
        $auteurSavegarder = $repository->sauvegarder($nouveauAuteur, true);

        return $this->json(['id' => $auteurSavegarder->getId(), "titre" => $auteurSavegarder->getNom()]);
    }

    #[Route("/auteur", name: "auteur.all", methods: ["GET"])]
    function recupererTousAuteurs(AuteurRepository $repo)
    {
        $auteurs = $repo->findAll();
        $auteursTab = [];
        foreach ($auteurs as $auteur) {
            $auteursTab[] = ['id' => $auteur->getId(), "nom" => $auteur->getNom()];
        }

        return $this->json($auteursTab);
    }

    #[Route("/auteur/{identifiant}", name: "auteur.one", methods: ["GET"])]
    function recupererAuteur(AuteurRepository $repo, $identifiant)
    {
        $auteur = $repo->find($identifiant);
        if (!$auteur) {
            return $this->json('Auteur introuvable', Response::HTTP_NOT_FOUND);
        }
        return $this->json(['id' => $auteur->getId(), "nom" => $auteur->getNom()]);
    }

    #[Route("/auteur/{id}", name: "auteur.update", methods: ["POST"])]
    function misAjourLivre(Request $req, AuteurRepository $repository, $id)
    {
        // Récuperer les données depuis la requete
        $nom = $req->request->get('nom');
        $prenom = $req->request->get('prenom');
        $date = $req->request->get('date');

        // Valider le titre
        if (!isset($nom) || $nom == "" || !isset($prenom) || $prenom == "" || !isset($date) || $date == "") {
            return $this->json(['erreur' => "Données obligatoires !"]);
        }

        $auteur = $repository->find($id);

        if (!$auteur) {
            return $this->json('Auteur introuvable', Response::HTTP_NOT_FOUND);
        }

        $auteur->setNom($nom)->setPrenom($prenom)->setDate($date);

        // Enregistrer le livre dans la BDD
        $auteurSavegarder = $repository->sauvegarder($auteur, true);

        return $this->json(['id' => $auteurSavegarder->getId(), "titre" => $auteurSavegarder->getNom()]);
    }

    #[Route("/auteur/{identifiant}", name: "auteur.one", methods: ["DELETE"])]
    function supprimerAuteur(AuteurRepository $repo, $identifiant)
    {
        $auteur = $repo->find($identifiant);
        if (!$auteur) {
            return $this->json('Auteur introuvable', Response::HTTP_NOT_FOUND);
        }
        $repo->supprimer($auteur);
        return $this->json("Auteur supprimer");
    }
    #[Route("/auteur/livre/{auteur_id}", name: "auteur.livre", methods: ["POST"])]

    function ajouterLivre(AuteurRepository $auteurrepo, Request $req, $auteur_id)
    {
        $auteur = $auteurrepo->find($auteur_id);

        if (!$auteur) {
            return $this->json('Auteur introuvable', Response::HTTP_NOT_FOUND);
        }

        $titre = $req->request->get('titre');

        if (!isset($titre) || $titre == "") {
            return $this->json(['erreur' => "Titre obligatoire !"]);
        }

        $livre = new Livre();
        $livre->setTitre($titre);

        $auteur->addLivre($livre);

        $auteurrepo->sauvegarder($auteur,true);

        return $this->json(["titre" => $livre->getTitre()]);


    }

}
