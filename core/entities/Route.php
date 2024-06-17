<?php

namespace Core\Entities;

/**
 * Objet définissant une route:
 * - son URL avec sa méthode d'appel HTTP
 * - son contrôleur avec sa méthode associés
 * - ses paramètres de route
 * - ses éventuels droits d'accès (`$allowedRoles`)
 */
class Route
{
    /**
     * URL de la route.
     * @var string
     */
    protected $url;

    /**
     * Méthode HTTP de la route.
     * @var string
     */
    protected $method;

    /**
     * Contrôleur associé à la route.
     * @var string
     */
    protected $controller;

    /**
     * Action associée à la route (méthode appelée du contrôleur).
     * @var string
     */
    protected $action;

    /**
     * Paramètres de l'URL de la route (id,..).
     * @var mixed[]
     */
    protected $params = [];

    /**
     * Crée une instance de Route.
     *
     * @param  string $method
     * @param  string $url
     * @param  string $controller
     * @param  string $action
     */
    public function __construct($method, $url, $controller, $action = '')
    {
        $method = strtoupper($method);
        if (!in_array($method, ["POST", "GET", "PUT", "DELETE"])) {
            throw new \BadMethodCallException("Une route HTTP ne peut pas avoir pour méthode '$method'.");
        }
        $this->method = $method;
        $this->url = $url;
        $this->setController($controller);
        $this->action = $action;
    }

    /**
     * Ajoute un paramètre de route.
     *
     * @param  string $name
     * @param  mixed  $value
     * @return void
     */
    public function addParam($name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * Getter magique.
     *
     * @param  string $name
     * @return mixed|void
     */
    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    /**
     * Setter : $controller.
     *
     * @param  string $value
     * @return void
     */
    public function setController($value)
    {
        $this->controller = "App\Controllers\\" . $value;
    }

    /**
     * Supprime le paramètre 'action'.
     * Pour ne pas l'envoyer dans les arguments de la méthode.
     *
     * @return void
     */
    public function unsetParamAction()
    {
        unset($this->params['action']);
    }
}
