<?php

namespace App\Controllers\Api;

use App\Functions\HttpUtils;
use Core\Alert;

class AlerteControllerApi
{
    /**
     * Renvoie et supprime toutes les alertes stockées dans la session.
     *
     * @route("/alertes", methods={"GET"})
     */
    public function getAll()
    {
        HttpUtils::jsonResponse(Alert::get());
    }
}
