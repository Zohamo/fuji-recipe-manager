<?php

use Core\Router;

/**
 * Définition des routes web.
 *
 * Lors de la définition de l'URL, mettre les paramètres de route entre {},
 * exemple : "fruits/{id}/modifier".
 *
 * Par défaut, les paramètres de route n'acceptent que les caractères alphanumériques, les '-' et les '_'.
 *
 * Pour définir une expression régulière particulière à un paramètre de route, il faut l'ajouter après ':',
 * exemple : "roles/{id:\d+}/modifier", ici 'id' n'accepte que les chiffres.
 */

// Route par défaut
Router::get("", "AccueilController", "index");

// Suppression de la session Utilisateur
Router::get("deconnexion", "AccueilController", "deconnexion");

// Recherche
Router::get("recherche", "RechercheController");
Router::post("recherche", "RechercheController");

// Journal d'erreurs
Router::get("tools/logs", "Tools\LogController", "index");
Router::get("tools/logs/files/{filename:[a-zA-Z0-9-.]*}", "Tools\LogController", "getFile");

// Outils
Router::get("tools/{action}", "Tools\ToolsController");
Router::post("tools/{action}", "Tools\ToolsController");
