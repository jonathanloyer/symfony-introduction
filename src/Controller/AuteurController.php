<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuteurController extends AbstractController
{
    #[Route('/auteur', name: 'auteurs.create', methods: ['POST'])]
    function creerauteur(Request $req, AuteurRepository $repository) {

        $nom = $req->request->get('nom');
        $prenom = $req->request->get('prenom');
        $date = $req->request->get('date');

        if (!isset($nom) || $nom == ""|| !isset($prenom) || $prenom == ""||!isset($date) || $date == "") {
            return $this->json(['erreur' => "Remplir le champ !"]);
        }

        $nouveauAuteur = new Auteur();
        $nouveauAuteur->setNom($nom);
        $nouveauAuteur->setPrenom($prenom);
        $nouveauAuteur->setDate($date);

        $auteurSave = $repository->save($nouveauAuteur,true);

        return$this->json(['id' => $auteurSave->getId(), "nom" => $auteurSave->getNom(),"prenom" => $auteurSave->getPrenom(),"date" => $auteurSave->getDate()]);

    }
    #[Route('/auteur', name: 'auteurs.tout', methods: ['GET'])]
    // on injecte la dépendance dans les paramétres de la fonction pour cette fonction $repo est injecter dans LivreRepository
    function recuperetTousAuteur(AuteurRepository $repo)
    {
        $auteurs = $repo->findAll();

        $auteurTableau = [];

        foreach ($auteurs as $auteur) {
            $auteurTableau[] = ['id' => $auteur->getId(), 'nom' => $auteur->getNom(),'prenom' => $auteur->getPrenom(),'date' => $auteur->getDate()];
        }

        return $this->json($auteurTableau);
    }
    #[Route('/auteur/{id}', name: 'auteurs.id', methods: ['GET'])]
    function recupererAuteur(AuteurRepository $repo, $id)
    {
        // Récuperer le livre avec son Id
        $auteur = $repo->find($id);
        // Si l'auteur n'existe pas on retourne 404
        if (!$auteur) {
            return $this->json("l'auteur n'existe pas", Response::HTTP_NOT_FOUND);
        }

        // Retouner l'auteur récupérer
        return $this->json(['id' => $auteur->getId(), 'nom' => $auteur->getNom(),'prenom' => $auteur->getPrenom(),'date' => $auteur->getDate()]);
    }
    #[Route('/auteur/{id}', name: 'auteurs.update', methods: ['POST'])]

    function mettreAjourAuteur($id, AuteurRepository $repo, Request $req)
    {
        // Récuperer le livre avec son Id

        $auteur = $repo->find($id);

        // Si le livre n'existe pas on retourne 404

        if (!$auteur) {
            return $this->json("l'auteur n'existe pas", Response::HTTP_NOT_FOUND);
        }
        // RECUPERER LE TITRE DU CORP DE LA REQUETE
        $nouveauNom = $req->request->get('nom');
        $nouveauPrenom = $req->request->get('prenom');
        $nouveauDate = $req->request->get('date');


        // VALDER LE NOUVEAU TITRE
        if (!isset($nom) || $nom == ""|| !isset($prenom) || $prenom == ""||!isset($date) || $date == "") {
            return $this->json(['erreur' => "Remplir le champ !", Response::HTTP_BAD_REQUEST]);
        }
        // METTRE A JOUR LE LIVRE
        $auteur->setNom($nouveauNom);
        $auteur->setPrenom($nouveauPrenom);
        $auteur->setDate($nouveauDate);


        // Enregistre le divre dans la BDD
        $repo->save($auteur, true);

        return $this->json($auteur->getNom() . 'auteur mis à jour !');
    }
    #[Route('/livre/{id}', name: 'livres.supprimer', methods: ['DELETE'])]

    function supprimerAuteur($id, AuteurRepository $repo)
    {
        // Récupérer le livre avec on identifiant
        $auteur = $repo->find($id);

        // Si le livre n'existe pas on retourne un 404
        if (!$auteur) {
            return $this->json("l'auteur' n'existe pas", Response::HTTP_NOT_FOUND);
        }

        // Supprmer le livre de la BDD
        $repo->supprimer($auteur);

        // Retourner un message
        return $this->json("Auteur supprimer");

    }
}
