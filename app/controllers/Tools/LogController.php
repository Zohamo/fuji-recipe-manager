<?php

namespace App\Controllers\Tools;

use App\Models\LogModel;
use Core\AbstractController;
use Core\View;

/**
 * Ce contrôleur permet l'affichage du journal des erreurs UNIQUEMENT
 * pour l'administrateur technique pour faciliter le débogage de l'application.
 */
class LogController extends AbstractController
{
    /**
     * Titre de la page d'accueil de la ressource.
     * @var string
     */
    public $homeTitle = "Journal d'erreurs";

    /**
     * Liens à mettre en valeur dans la barre de navigation.
     * @var string[]
     */
    protected $activeLinks = ['administration-technique', 'logs'];

    /**
     * Modèle associé au contrôleur.
     * @var LogModel
     */
    protected $model;

    /**
     * Définit les liens à mettre en valeur dans la vue et le modèle.
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new LogModel();
    }

    /**
     * Affiche une liste des ressources.
     *
     * @route("/tools/logs", methods={"GET"})
     */
    public function index()
    {
        View::render(
            // Vue à utiliser dans le dossier `views`
            'tools/log/index',
            // Paramètres à afficher dans la vue
            [
                // Titre de la page
                'title' => $this->homeTitle,
                // Liste des ressources à afficher
                'logs' => $this->model
                    ->leftJoin("t_utilisateur", "log_uti_compte_ldap = uti_compte_ldap")
                    ->order("log_date DESC")
                    ->select(),
                'files' => array_reverse(array_filter(
                    \App\Functions\DirectoryUtils::listContent(path("logs")),
                    function ($filename) {
                        return $filename !== ".htaccess";
                    }
                ))
            ],
            // Liste des modules/scripts à implémenter
            ['modules' => ['data-tables']]
        );
    }

    /**
     * AJAX : renvoie le contenu d'un fichier de log.
     *
     * @return exit
     * @route("/tools/logs/files/{filename}", methods={"GET"})
     */
    public function getFile($filename)
    {
        if (file_exists(path("logs") . "/$filename")) {
            exit(file_get_contents(path("logs") . "/$filename"));
        }
        exit("Fichier '$filename' introuvable");
    }
}
