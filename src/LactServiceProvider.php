<?php

declare(strict_types=1);

namespace Msamgan\Lact;

use Msamgan\Lact\Commands\ClearCommand;
use Msamgan\Lact\Commands\CreateRoutesCommand;
use Msamgan\Lact\Commands\LactCommand;
use Msamgan\Lact\Commands\ProcessRoutesCommand;
use Msamgan\Lact\Commands\RouteCommand;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
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
            ->hasRoute('lact')
            ->hasCommands([
                LactCommand::class,
                ClearCommand::class,
                CreateRoutesCommand::class,
                ProcessRoutesCommand::class,
                RouteCommand::class,
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->askToStarRepoOnGitHub('msamgan/lact');
            });
    }
}
