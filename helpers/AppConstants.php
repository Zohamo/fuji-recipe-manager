<?php

/**
 * Constantes globales relatives à l'application.
 */
final class AppConstants
{
    /**
     * Clé du jeton CSRF dans $_SESSION.
     * @var string
     */
    const CSRF_TOKEN_KEY = "CSRFToken";

    /**
     * Format de date MySQL.
     * @var string
     */
    const FORMAT_DATE = "Y-m-d";

    /**
     * Format de date pour l'affichage HTML.
     * @var string
     */
    const FORMAT_DATE_DISPLAY = "d/m/Y";

    /**
     * Format de date/heure MySQL.
     * @var string
     */
    const FORMAT_DATETIME = "Y-m-d H:i:s";

    /**
     * Format de date/heure pour l'affichage HTML.
     * @var string
     */
    const FORMAT_DATETIME_DISPLAY = "d/m/Y H:i:s";

    /**
     * Codes HTTP reconnus par PHP.
     */
    const HTTP_CODES_PHP_ACCEPT = [
        0, 100, 101, 102, 200, 208, 226, 300, 305, 307,
        400, 417, 422, 424, 426, 428, 429, 431, 500, 508, 510, 511
    ];

    /**
     * Version du Framework Tela.
     * @var string
     */
    const TELA_VERSION = "1.8.11";

    /**
     * URL relative du manuel d'utilisateur de l'application.
     * @var string
     */
    const URL_AIDE = "";
}
