<?php

namespace App\Functions;

/**
 * Fonctions utilitaires pour les chaînes de caractères.
 */
class StringUtils
{
    /**
     * Renvoie l'index de la première chaîne de caractères contenant une chaîne de
     * caractères ($needle) dans un tableau ($haystack).
     *
     * @param  string[] $haystack
     * @param  string $needle
     * @return integer|false Index du premier élément trouvé ou `false`.
     */
    public static function arrayContains(array $haystack, string $needle)
    {
        return array_search(
            true,
            array_map(function ($k) use ($needle) {
                return strpos($k, $needle) !== false;
            }, $haystack)
        );
    }

    /**
     * Transforme une chaîne de caractères en camelCase.
     *
     * @param  string $str
     * @param  string $delimiter Caractère utilisé pour séparer les mots de la source.
     * @return string
     */
    public static function camel($str, $delimiter = " ")
    {
        return lcfirst(self::pascal($str, $delimiter));
    }

    /**
     * Ajoute des espaces à une chaîne de caractères en camelCase ou PascalCase et la met en minuscules.
     *
     * @example: "fooBar" devient "foo bar"
     * @param  string $str
     * @return string
     */
    public static function camelToSpaced($str)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $str, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode(' ', $ret);
    }

    /**
     * Met le premier caractère d'une chaîne en majuscule (même s'il comporte un accent).
     *
     * @param  string $str
     * @return string
     */
    public static function capitalize($s)
    {
        return mb_strtoupper(mb_substr($s, 0, 1)) . mb_substr($s, 1);
    }

    /**
     * Nettoie une chaîne de caractères passée dans un champ de recherche.
     *
     * @param  string $str
     * @return string
     */
    public static function cleanSearchString($str)
    {
        return htmlspecialchars(strtolower(self::reduceCharacters(trim($str))));
    }

    /**
     * Réduit la redondance d'espaces et de sauts de ligne dans une chaîne de caractères.
     *
     * @param  string $txt
     * @return string
     */
    public static function cleanText($txt)
    {
        // supprime les espaces en trop
        $txt = self::reduceCharacters(trim($txt));
        // supprime les lignes avec des espaces
        while (strpos($txt, "\n \n") !== false) {
            $txt = str_replace("\n \n", "\n", $txt);
        }
        // supprime les sauts de ligne trop importants
        while (strpos($txt, "\n\n\n") !== false) {
            $txt = str_replace("\n\n\n", "\n\n", $txt);
        }
        // supprime les sauts de ligne en début de texte
        while (strpos($txt, "\n") === 0) {
            $txt = substr($txt, 2);
        }
        return $txt;
    }

    /**
     * Coupe une chaîne d'un certain nombre de caractères et ajoute '...'.
     *
     * @param  string $str
     * @param  integer $length
     * @param  string $end Chaîne à ajouter à la fin de la chaîne coupée.
     * @return string
     */
    public static function cutString($str, $length = 50, $end = "&hellip;")
    {
        return strlen($str) <= $length ? $str : trim(substr($str, 0, $length)) . $end;
    }

    /**
     * Transforme une chaîne de caractères en kebab-case.
     *
     * @param  string $str
     * @param  string $delimiter Caractère utilisé pour séparer les mots de la source.
     * @return string
     */
    public static function kebab($str, $delimiter = " ")
    {
        return str_replace($delimiter, "-", self::cleanSearchString($str));
    }

    /**
     * Transforme une chaîne de caractères en PascalCase.
     *
     * @param  string $str
     * @param  string $delimiter Caractère utilisé pour séparer les mots de la source.
     * @return string
     */
    public static function pascal($str, $delimiter = " ")
    {
        return implode("", array_map(function ($word) {
            return self::capitalize($word);
        }, explode($delimiter, self::cleanSearchString($str))));
    }

    /**
     * Prettifie une requête SQL.
     *
     * @param  string $query
     * @return string
     */
    public static function prettifySqlQuery($query)
    {
        // remplace les retours par des espaces
        $query = preg_replace("/[\r\n]/", " ", $query);
        // supprime les espaces en trop
        $query = self::reduceCharacters(trim($query));
        return str_replace(" ,", ",", $query);
    }

    /**
     * Réduit le nombre de plusieurs chaînes de caractères similaires
     * consécutives à un seul élément dans une chaîne de caractères.
     *
     * Supprime les espaces en trop par défaut.
     *
     * @param  string $str
     * @return string
     */
    public static function reduceCharacters($str, $char = " ")
    {
        while (strpos($str, "$char$char") !== false) {
            $str = str_replace("$char$char", $char, $str);
        }
        return $str;
    }

    /**
     * Remplace les caractères spéciaux d'une chaîne (accents, cédilles,..) par des caractères simples.
     *
     * @param string $str
     * @return string
     */
    public static function replaceSpecialChars($str)
    {
        $utf8 = include("assets/special-characters.php");
        return str_replace(array_keys($utf8), array_values($utf8), $str);
    }

    /**
     * Transforme une chaîne de caractères en snake_case.
     *
     * @param  string $str
     * @param  string $delimiter Caractère utilisé pour séparer les mots de la source.
     * @return string
     */
    public static function snake($str, $delimiter = " ")
    {
        return str_replace($delimiter, "_", self::cleanSearchString($str));
    }

    /**
     * Change le formatage d'une chaîne de caractères.
     * Options :
     * - kebab-case ('k', 'kebab')
     * - PascalCase ('p', 'pascal')
     * - camelCase ('c', 'camel')
     *
     * @param  string $string
     * @param  string $case
     * @param  string $delimiter Caractère utilisé pour séparer les mots de la source.
     * @return string
     */
    public static function switchCase($str, $case = null, $delimiter = " ")
    {
        switch ($case) {
            case 'k':
            case 'kebab';
                $str = self::kebab($str, $delimiter);
                break;
            case 'p':
            case 'pascal':
                $str = self::pascal($str, $delimiter);
                break;
            case 'c':
            case 'camel':
                $str = self::camel($str, $delimiter);
                break;
            case '':
            default:
        }
        return $str;
    }
}
