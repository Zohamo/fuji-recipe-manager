<?php

namespace App\Functions;

/**
 * Fonctions utilitaires sur le SQL.
 */
class SqlUtils
{
    /**
     * Renvoie la valeur min ou max d'un type de nombre SQL.
     *
     * @param  string $value 'min' ou 'max'.
     * @param  string $type 'tinyint', 'smallint', 'mediumint', 'int' ou 'bigint'.
     * @param  boolean $unsigned
     * @return int|false
     */
    public static function getValue($value, $type, $unsigned = false)
    {
        $values = include("assets/sql-values.php");
        $type = strtolower($type);
        $sign = $unsigned ? "unsigned" : "signed";
        if (!isset($values[$type]) || !in_array($value, ['min', 'max'])) {
            return false;
        }
        return $values[$type][$sign][$value];
    }

    /**
     * Renvoie la valeur maximale d'un type de nombre SQL.
     *
     * @param  string $type 'tinyint', 'smallint', 'mediumint', 'int' ou 'bigint'.
     * @param  boolean $unsigned
     * @return int|false
     */
    public static function maxValue($type, $unsigned = false)
    {
        return self::getValue("max", $type, $unsigned);
    }

    /**
     * Renvoie la valeur minimale d'un type de nombre SQL.
     *
     * @param  string  $type 'tinyint', 'smallint', 'mediumint', 'int' ou 'bigint'.
     * @param  boolean $unsigned
     * @return int|false
     */
    public static function minValue($type, $unsigned = false)
    {
        return self::getValue("min", $type, $unsigned);
    }

    /**
     * Renvoie les différents types numériques de SQL.
     *
     * @return string[]
     */
    public static function numberTypes()
    {
        return [
            'tinyint', 'smallint', 'mediumint', 'int', 'bigint',
            'float', 'double', 'decimal'
        ];
    }

    /**
     * Reçoit un type SQL et renvoie un type générique.
     *
     * @param  string $type
     * @return string 'integer', 'float', 'date', 'datetime', 'time' ou 'string'.
     */
    public static function typeGeneric($type)
    {
        switch ($type) {
            case "tinyint":
            case "smallint":
            case "int":
            case "bigint":
            case "year":
                $type = "integer";
                break;
            case "decimal":
            case "float":
            case "real":
            case "double":
                $type = "float";
                break;
            case "date":
                $type = "date";
                break;
            case "datetime":
            case "timestamp":
                $type = "datetime";
                break;
            case "time":
                $type = "time";
                break;
            case "char":
            case "varchar":
            case "tinytext":
            case "text":
            case "mediumtext":
            case "longtext":
            default:
                $type = "string";
        }
        return $type;
    }
}
