<?php

namespace MohamedSaid\Notable;

use MohamedSaid\Notable\Commands\NotableCommand;
use MohamedSaid\Notable\Observers\NotableObserver;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NotableServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('notable')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_notable_table')
            ->hasCommand(NotableCommand::class);
    }

    public function packageBooted(): void
    {
        Notable::observe(NotableObserver::class);
    }
}
