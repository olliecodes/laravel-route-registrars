<?php

declare(strict_types=1);

namespace OllieCodes\Registrars\Contracts;

use Illuminate\Contracts\Routing\Registrar;

/**
 * Route Registrar Contract
 *
 * Represents a collection of routes, arbitrarily grouped. Serves as the basis of
 * the object based routing approach, replacing the need for the routes directory.
 */
interface RouteRegistrar
{
    /**
     * Map the routes this class represents.
     *
     * @param \Illuminate\Contracts\Routing\Registrar $registrar
     *
     * @return void
     */
    public function map(Registrar $registrar): void;
}