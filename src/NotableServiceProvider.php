<?php

namespace MohamedSaid\Notable;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use MohamedSaid\Notable\Commands\NotableCommand;

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
