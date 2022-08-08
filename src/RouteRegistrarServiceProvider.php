<?php

declare(strict_types=1);

namespace OllieCodes\Registrars;

use Illuminate\Support\ServiceProvider;
use OllieCodes\Registrars\Commands\InitRoutingCommand;
use OllieCodes\Registrars\Commands\RouteRegistrarMakeCommand;

class RouteRegistrarServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InitRoutingCommand::class,
                RouteRegistrarMakeCommand::class,
            ]);
        }
    }
}