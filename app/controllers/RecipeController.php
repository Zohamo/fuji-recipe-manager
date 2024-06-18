<?php

namespace App\Controllers;

use App\Models\RecipeModel;
use Core\AbstractController;
use Core\View;

class RecipeController extends AbstractController
{
    /**
     * Affiche la page d'accueil.
     *
     * @route("/", methods={"GET"})
     */
    public function index()
    {
        View::render(
            'recipes/index',
            [
                'recipes' => (new RecipeModel)->all()
            ],
            ["modules" => ["data-tables", "form-modal"]]
        );
    }
}
