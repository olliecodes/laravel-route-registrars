<?php

declare(strict_types=1);

namespace OllieCodes\Registrars\Commands;

use Illuminate\Console\ConfirmableTrait;
use Illuminate\Console\GeneratorCommand;

class InitRoutingCommand extends GeneratorCommand
{
    use ConfirmableTrait;

    protected $signature = 'init:routing';

    protected $description = 'Initialise the toolkit routing functionality.';

    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return self::FAILURE;
        }

        $this->warn('This command will overwrite the following file:');
        $this->line('app/Providers/RouteServiceProvider.php');

        if (! $this->confirm('Are you sure you wish to proceed?')) {
            return self::FAILURE;
        }

        $this->overwriteRouteServiceProvider();
        $this->createDirectories();
        $this->addDefaultRoutes();

        return self::SUCCESS;
    }

    protected function getStub(): string
    {
        return '';
    }

    private function getReplacement(string $stubName, string $name): string
    {
        $stub = $this->files->get($stubName);
        $this->replaceNamespace($stub, $name);
        return $this->sortImports($stub);
    }

    private function addDefaultRoutes(): void
    {
        $defaultRoutes = [
            'WebRoutes'          => 'web-route-registrar.stub',
            'Web\\DefaultRoutes' => 'web-default-route-registrar.stub',
            'ApiRoutes'          => 'api-route-registrar.stub',
            'Api\\DefaultRoutes' => 'api-default-route-registrar.stub',
        ];

        foreach ($defaultRoutes as $class => $stub) {
            if ($this->createClass('Http\\Routes\\' . $class, $stub)) {
                $this->info('Route registrar \'' . $class . '\' written');
            } else {
                $this->error('Unable to write \'' . $class . '\' class');
            }
        }
    }

    private function createDirectories(): void
    {
        $directories = [
            app_path('Http/Routes'),
            app_path('Http/Routes/Web'),
            app_path('Http/Routes/Api')

        ];

        foreach ($directories as $directory) {
            if (! $this->files->isDirectory($directory)) {
                $this->files->makeDirectory($directory);
                $this->info('Created directory: ' . $directory);
            }
        }
    }

    private function overwriteRouteServiceProvider(): void
    {
        if ($this->createClass('Providers\\RouteServiceProvider', 'route-service-provider.stub')) {
            $this->info('Route service provider replaced');
        }
    }

    private function createClass(string $class, string $stub): bool
    {
        return $this->files->put(
                app_path(str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php'),
                $this->getReplacement(
                    __DIR__ . '/../../resources/stubs/' . $stub,
                    $class
                )
            ) !== false;
    }
}