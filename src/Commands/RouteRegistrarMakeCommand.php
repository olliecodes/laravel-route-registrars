<?php

declare(strict_types=1);

namespace OllieCodes\Registrars\Commands;

use Illuminate\Console\ConfirmableTrait;
use Illuminate\Console\GeneratorCommand;

class RouteRegistrarMakeCommand extends GeneratorCommand
{
    use ConfirmableTrait;

    protected $signature = 'make:registrar {name : The name of the route registrar}
        {--C|hasChildren : Create the route registrar as a parent}
        {--W|web : Create as a web route registrar}
        {--A|api : Create as an API route registrar}';

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
        $namespace = $rootNamespace . '\\Http\\Routes';

        if ($this->option('web')) {
            $namespace .= '\\Web';
        } else if ($this->option('api')) {
            $namespace .= '\\Api';
        }

        return $namespace;
    }
}