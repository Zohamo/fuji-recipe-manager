<?php

namespace App\Controllers\Tools;

use Core\AbstractController;

/**
 * Ce contrôleur contient des outils destinés UNIQUEMENT à l'administrateur technique
 * pour faciliter le débogage de l'application.
 */
class ToolsController extends AbstractController
{
    /**
     * Supprime les données de la session en cours.
     *
     * @param  mixed[] $req Tableau associatif contenant les données de $_POST, $_GET et $_COOKIE.
     * @return void
     * @route("/tools/detruire-session", methods={"GET"})
     */
    public function detruireSession(array $req)
    {
        session_destroy();

        redirect(!empty($req['redirect']) ? $req['redirect'] : '');
    }
}
