<?php

namespace Msamgan\Lact;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Msamgan\Lact\Commands\LactCommand;

class LactServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('lact')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_lact_table')
            ->hasCommand(LactCommand::class);
    }
}
