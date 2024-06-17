<?php

namespace Core\Entities;

use Core\AbstractEntity;

/**
 * Objet représentant une clause SQL avec sa commande et son séparateur.
 */
class SqlClause extends AbstractEntity
{
    /**
     * Commande SQL.
     * @example: 'LEFT JOIN', 'LIMIT'
     * @var string
     */
    protected $command;

    /**
     * Séparateur de cette clause.
     * @example: ' AND ', ' OR '
     * @var string
     */
    protected $separator;
}
