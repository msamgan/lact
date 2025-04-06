<?php

namespace Msamgan\Lact;

use Msamgan\Lact\Commands\LactCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasCommand(LactCommand::class);
    }
}
