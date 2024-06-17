<?php

/*
 |--------------------------------------------------------------------------
 | Fonctions utilitaires de l'application
 |--------------------------------------------------------------------------
 |
 | Ces fonctions regroupent des utilitaires, des raccourcis, des fonctions
 | de débogage, etc...
 | Elles sont chargées en tout premier lieu dans index.php.
 |
*/

// Définit la Timezone par défaut pour éviter les erreurs liées à date()
date_default_timezone_set('Europe/Paris');

use Symfony\Component\VarDumper\VarDumper;

/********************************************************************
 * DÉBOGAGE
 ********************************************************************/

/**
 * Affiche les informations structurées d'une variable, y compris son type et sa valeur.
 * Version améliorée de `var_dump`.
 *
 * @param  mixed $var
 * @param  mixed $moreVars
 * @return mixed Renvoie les arguments passés.
 * @author Nicolas Grekas <p@tchwork.com>
 * @package \Symfony\var-dumper
 */
function dump($var, ...$moreVars)
{
    echo "<small class='text-muted'>" . debug_backtrace()[0]['file'] . "(" . debug_backtrace()[0]['line'] . ")</small>";
    VarDumper::dump($var);
    foreach ($moreVars as $v) {
        VarDumper::dump($v);
    }
    return func_num_args() > 1 ? func_get_args() : $var;
}

/**
 * Affiche les informations structurées d'une variable puis arrête le script.
 *
 * @param  mixed $vars
 * @return mixed|exit
 * @author Nicolas Grekas <p@tchwork.com>
 * @package \Symfony\var-dumper
 * @see: function dump()
 */
function dd(...$vars)
{
    if (!in_array(\PHP_SAPI, ['cli', 'phpdbg'], true) && !headers_sent()) {
        header('HTTP/1.1 500 Internal Server Error');
    }
    echo "<small class='text-muted'>" . debug_backtrace()[0]['file'] . "(" . debug_backtrace()[0]['line'] . ")</small>";
    foreach ($vars as $v) {
        VarDumper::dump($v);
    }
    exit(1);
}

/**
 * Affiche la trace de pile (liste des appels des méthodes).
 *
 * @return void
 */
function backtrace()
{
    echo "<small class='text-muted'>" . str_replace("\n", "<br />", (new \Exception)->getTraceAsString()) . "</small>";
}

/**
 * Affiche des données dans la console.
 *
 * @param  mixed $data
 * @return void
 */
function consoleLog($data = null)
{
    echo "<script>console.log(" . json_encode($data) . ")</script>";
}

/**
 * Affiche des données dans le header HTTP.
 *
 * @param  mixed $data
 * @return void
 */
function headerLog($data = null)
{
    $bt = debug_backtrace();
    $caller = array_shift($bt);
    dump($caller);
    $line = $caller['line'];
    $expl = explode('\\', $caller['file']);
    dump($expl);
    $file = array_pop($expl);
    dump($file);
    header("log-$file-$line: " . json_encode($data));
}

/**
 * Affiche toutes les variables ('var'), constantes ('const'), fonctions ('fn') ou tout ('all').
 *
 * @param string $type 'var', 'const', 'fn' ou 'all'.
 * @return void
 */
function printAll($type = 'var')
{
    $all = [];
    switch ($type) {
        case 'const':
            $all = get_defined_constants();
            break;
        case 'fn':
            $all = get_defined_functions()['user'];
            break;
        case 'all':
            $all['var'] = get_defined_vars();
            $all['const'] = get_defined_constants();
            $all['fn'] = get_defined_functions()['user'];
            break;
        case 'var':
        default:
            $all = get_defined_vars();
    }
    dump($all);
}

/********************************************************************
 * RACCOURCIS
 ********************************************************************/

/**
 * Renvoie les alias d'un modèle.
 *
 * @param  string $modelName
 * @return string[]
 * @see: \App\aliases
 */
function aliases($modelName)
{
    $file = path('aliases') . '/' . str_replace('Model', 'Alias.php', (substr($modelName, strrpos($modelName, '\\') + 1)));
    return is_readable($file) ? include $file : null;
}

/**
 * Renvoie une constante de configuration depuis "composer.json".
 *
 * @param string $keys,... Clés imbriquées pour accéder à la valeur.
 * @return string
 * @throws LogicException
 *
 * @example: $docsUrl = config("support", "docs");
 */
function config(...$keys)
{
    $json = file_get_contents(path() . "/composer.json");
    $result = json_decode($json, true);
    foreach ($keys as $key) {
        if (isset($result[$key])) {
            $result = $result[$key];
        } else {
            throw new \LogicException("La clé imbriquée '$key' n'existe pas dans 'composer.json'.");
        }
    }
    return $result;
}

/**
 * Déchiffre une chaîne de caractères passée dans une URL.
 *
 * @param  string $str
 * @return string
 */
function decrypt($str)
{
    return \App\Functions\CryptUtils::decryptUrl($str);
}

/**
 * Chiffre une chaîne de caractères ou un nombre à passer dans une URL.
 *
 * @param  string|int|float $str
 * @return string
 */
function encrypt($str)
{
    return \App\Functions\CryptUtils::encryptUrl($str);
}

/**
 * Renvoie une constante d'environnement.
 *
 * @param  string $key
 * @return string|integer|double|boolean
 * @throws LogicException
 */
function env($key)
{
    if ($key === "APP_ROOT" && empty($_ENV[$key])) {
        // Renvoie le chemin à la racine du projet s'il n'est pas défini
        $val = realpath('');
    } elseif (!isset($_ENV[$key])) {
        // Renvoie une erreur si la clé n'est pas définie
        throw new \LogicException("'$key' n'est pas défini dans les constantes d'environnement.");
    } else {
        // Gère les booléens
        switch ($_ENV[$key]) {
            case "true":
                $val = true;
                break;
            case "false":
                $val = false;
                break;
            default:
                $val = $_ENV[$key];
        }
    }
    return $val;
}

/**
 * Lance une Exception.
 *
 * @see Core\Error::exceptionHandler()
 *
 * @param  integer $code
 * @param  string  $message
 * @return never
 * @throws Exception
 */
function error($code, $message = "")
{
    throw new \Exception($message, $code);
}

/**
 * Création d'un fichier de log.
 *
 * @param  \Exception $exception
 * @return boolean
 */
function errorLog(\Exception $exception)
{
    $message = "::: " . date('Y-m-d H:i:s') . " :::";
    $message .= "\nCode : " . $exception->getCode() ?: null;
    $message .= "\nException : " . get_class($exception);
    $message .= "\nMessage : " . $exception->getMessage();
    $message .= "\nTrace de pile :\n" . $exception->getTraceAsString();
    $message .= "\nDétecté dans '{$exception->getFile()}' ligne {$exception->getLine()}\n\n";
    error_log($message, 3, path('logs') . "/" . date('Y-m-d') . ".txt");
}

/**
 * Renvoie le chemin absolu d'un répertoire.
 *
 * @param  string $key
 * @return string
 * @see: \helpers\directories
 */
function path($key = "root")
{
    $dir = include 'directories.php';
    return env('APP_ROOT') . "$dir[$key]";
}

/**
 * Renvoie l'URL absolue d'un répertoire ou d'une route.
 *
 * @param  string $key Clé du répertoire ou route relative.
 * @return string
 * @see: \helpers\directories
 */
function url($key = "root")
{
    if (!$key || $key === "root") {
        return env('APP_URL');
    }
    $dir = include 'directories.php';
    return env('APP_URL') . (isset($dir[$key]) ? "$dir[$key]" : "/$key");
}

/**
 * Redirige vers l'URL relative demandée.
 *
 * @param  string $url ex: 'admin/utilisateurs'
 * @return void
 */
function redirect($url = null)
{
    $header = "Location: " . url();
    if ($url && substr(strtolower($url), 0, 4) !== "http") {
        $header .= "/$url";
    }
    header($header);
}

/********************************************************************
 * AFFICHAGE
 ********************************************************************/

/**
 * Renvoie un alias d'une ressource.
 *
 * @param  string $resource  Nom de la ressource (en PascalCase ou camelCase).
 * @param  string $key       Clé de l'alias (nom de la colonne).
 * @return string
 */
function alias($resource, $key = null)
{
    $aliasFile = path('aliases') . "/" . ucfirst($resource) . "Alias.php";
    if (!is_readable($aliasFile)) {
        return \App\Functions\StringUtils::capitalize($key ?: $resource);
    }
    $aliases = include $aliasFile;
    if ($key && !empty($aliases[$key])) {
        return $aliases[$key];
    }
    return \App\Functions\StringUtils::capitalize($key ?: $resource);
}

/**
 * Convertit un format de date pour l'affichage.
 *
 * @param  string $date  Date au format 'Y-m-d'.
 * @param  string $after Format de date à afficher.
 * @return string
 */
function formatDate($date, $after = "")
{
    return \App\Functions\DateUtils::convert($date, 'Y-m-d', $after ?: \AppConstants::FORMAT_DATE_DISPLAY);
}

/**
 * Convertit un format de date pour l'affichage.
 *
 * @param  string $date  Date au format 'Y-m-d H:i:s'.
 * @param  string $after Format de date à afficher.
 * @return string
 */
function formatDatetime($date, $after = "")
{
    return \App\Functions\DateUtils::convert($date, 'Y-m-d H:i:s', $after ?: \AppConstants::FORMAT_DATETIME_DISPLAY);
}

/**
 * Formate l'affichage des nombres au format français.
 *
 * @param  int|float $number
 * @param  int $decimals Nombre de décimales après la virgule.
 * @param  string $thousandsSeparator Séparateur de milliers.
 * @return string
 */
function formatNumber($number, $decimals = 0, $thousandsSeparator = "&nbsp;")
{
    return $number === null || is_nan($number) ? $number : number_format($number, $decimals, ',', $thousandsSeparator);
}

/**
 * Formate l'affichage de la taille d'un fichier.
 *
 * @param integer $size Taille en octets.
 * @return string
 */
function formatSize($size)
{
    if ($size < 1000) {
        $result = "$size octets";
    } elseif ($size < 1000000) {
        $ko = round($size / 1024, 2);
        $result = "$ko Ko";
    } elseif ($size < 1000000000) {
        $mo = round($size / (1024 * 1024), 2);
        $result = "$mo Mo";
    } else {
        $go = round($size / (1024 * 1024 * 1024), 2);
        $result = "$go Go";
    }
    return $result;
}

/**
 * Renvoie un temps dans un tableau ordonné pour l'affichage.
 *
 * @param float $time Temps en secondes.
 * @return integer[]
 */
function formatTime($time)
{
    $seconds = floor($time);
    $minutes = floor($seconds / 60);
    $ms = floor($time * 1000);

    return [
        'h' => floor($minutes / 60),
        'min' => $minutes % 60,
        'sec' => $seconds % 60,
        'ms' => $ms % 1000,
        'μs' => round(($time * 1000000) % 1000)
    ];
}
