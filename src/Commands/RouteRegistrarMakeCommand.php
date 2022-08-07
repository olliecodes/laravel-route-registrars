<?php

declare(strict_types=1);

namespace OllieCodes\Registrars\Commands;

use Illuminate\Console\ConfirmableTrait;
use Illuminate\Console\GeneratorCommand;

class RouteRegistrarMakeCommand extends GeneratorCommand
{
    use ConfirmableTrait;

    protected $signature = 'make:registrar {name : The name of the route registrar}
        {--C|hasChildren : Create the route registrar as a parent}';

    protected $description = 'Create a route registrar';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Route registrar';

    protected function getStub(): string
    {
        if ($this->option('hasChildren')) {
            return __DIR__ . '/../../resources/stubs/route-registrar.children.stub';
        }

        return __DIR__ . '/../../resources/stubs/route-registrar.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\\Http\\Routes';
    }
}