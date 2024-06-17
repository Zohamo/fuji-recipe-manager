<?php

namespace App\Controllers;

use Core\AbstractController;
use Core\View;

class AccueilController extends AbstractController
{
    /**
     * Liens à mettre en valeur dans la barre de navigation.
     * @var string[]
     */
    protected $activeLinks = ["accueil"];

    /**
     * Affiche la page d'accueil.
     *
     * @route("/", methods={"GET"})
     */
    public function index()
    {
        View::render('accueil/index');
    }

    /**
     * Supprime l'Utilisateur de la session.
     *
     * @param  mixed[] $req Tableau associatif contenant les données de $_POST, $_GET et $_COOKIE.
     * @return void
     * @route("/deconnexion", methods={"GET"})
     */
    public function deconnexion(array $req)
    {
        unset($_SESSION['utilisateur']);

        redirect(!empty($req['redirect']) ? $req['redirect'] : '');
    }
}
