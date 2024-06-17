<?php

namespace Core;

/**
 * Définit les relations entre une classe et d'autres avec des objets
 * `Relationship`.
 */
trait RelationshipTrait
{
    /**
     * Relations entre un modèle ou une entité avec d'autres.
     * @var Relationship[] Tableau associatif.
     */
    protected $relationships = [];

    /**
     * Définit les relations entre cette classe et d'autres.
     *
     * Cette méthode est généralement appelée dans le constructeur.
     *
     * @return $this
     */
    protected function setRelationships()
    {
        /*  Exemple avec UtilisateurModel :
        $this->relationships = [
            'role' => new Relationship('RoleModel', 'has-one', 'fk_role_id', 'rol_id')
        ]; */
        return $this;
    }
}
