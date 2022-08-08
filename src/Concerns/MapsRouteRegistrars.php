<?php

declare(strict_types=1);

namespace OllieCodes\Registrars\Concerns;

use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Str;
use OllieCodes\Registrars\Contracts\RouteRegistrar;
use ReflectionClass;
use RuntimeException;
use Symfony\Component\Finder\Finder;

/**
 * Maps Route Registrars Trait
 *
 * A helper trait to be added to any class that needs to map {@see \OllieCodes\Registrars\Contracts\RouteRegistrar}
 * instances.
 */
trait MapsRouteRegistrars
{
    /**
     * Create a new instance of a provided route registrar class.
     *
     * @param string $routeRegistrar
     *
     * @return \OllieCodes\Registrars\Contracts\RouteRegistrar
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function makeRouteRegistrar(string $routeRegistrar): RouteRegistrar
    {
        return app()->make($routeRegistrar);
    }

    /**
     * Map the routes.
     *
     * @param \Illuminate\Contracts\Routing\Registrar                         $router
     * @param class-string<\OllieCodes\Registrars\Contracts\RouteRegistrar>[] $registrars
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function mapRouteRegistrars(Registrar $router, array $registrars): void
    {
        foreach ($registrars as $registrar) {
            $this->mapRouteRegistrar($router, $registrar);
        }
    }

    /**
     * Map a route registrar.
     *
     * @param \Illuminate\Contracts\Routing\Registrar $router
     * @param string                                  $routeRegistrar
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function mapRouteRegistrar(Registrar $router, string $routeRegistrar): void
    {
        if (! is_subclass_of($routeRegistrar, RouteRegistrar::class)) {
            dd($routeRegistrar, class_exists($routeRegistrar), is_subclass_of($routeRegistrar, RouteRegistrar::class));
            throw new RuntimeException(sprintf(
                'Cannot map routes \'%s\', it is not a valid routes class',
                $routeRegistrar
            ));
        }

        $this->makeRouteRegistrar($routeRegistrar)
             ->map($router);
    }

    /**
     * Load route registrars from the provided paths.
     *
     * @param \Illuminate\Contracts\Routing\Registrar $router
     * @param array                                   $paths
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     */
    protected function loadRouteRegistrars(Registrar $router, array $paths): void
    {
        $paths = array_unique($paths);
        $paths = array_filter($paths, 'is_dir');

        if (empty($paths)) {
            return;
        }

        $namespace = app()->getNamespace();

        foreach ((new Finder)->in($paths)->files() as $registrar) {
            $registrar = $namespace . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($registrar->getRealPath(), realpath(app_path()) . DIRECTORY_SEPARATOR)
                );

            if (
                is_subclass_of($registrar, RouteRegistrar::class)
                && ! (new ReflectionClass($registrar))->isAbstract()
            ) {
                $this->mapRouteRegistrar($router, $registrar);
            }
        }
    }
}