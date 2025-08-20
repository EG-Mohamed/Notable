<?php

namespace MohamedSaid\Notable;

use MohamedSaid\Notable\Commands\NotableCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NotableServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('notable')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_notable_table')
            ->hasCommand(NotableCommand::class);
    }
}
