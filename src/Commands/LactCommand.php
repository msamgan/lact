<?php

namespace Msamgan\Lact\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class LactCommand extends Command
{
    public $signature = 'lact:build-actions';

    public $description = 'Build actions for Urls';

    public function handle(): int
    {
        $routes = $this->getRequiredUrls();

        foreach ($routes as $route) {
            $usesFragments = explode('\\', $route->getAction()['uses']);
            $lastFragment = array_pop($usesFragments);

            $fileFragments = explode('@', $lastFragment);
            $fileName = $fileFragments[0];
            $methodName = $fileFragments[1];

            $filePath = $this->ensureJsFileExists($fileName);
            $methodString = $this->createMethodString($route->getName(), $methodName);

            $this->appendToFileWithEmptyLine($filePath, $methodString);
        }

        return self::SUCCESS;
    }

    private function appendToFileWithEmptyLine(string $filePath, string $content): void
    {
        if (! str_contains(file_get_contents($filePath), $content)) {
            // Append the content followed by an empty line
            file_put_contents($filePath, $content.PHP_EOL.PHP_EOL, FILE_APPEND);
        }
    }

    private function createMethodString($routeName, $methodName): string
    {
        $baseString = "export const {{methodName}} = () => {\n\treturn fetch(route('{{routeName}}')).then(response => response)\n}";

        $functionString = str_replace('{{methodName}}', $methodName, $baseString);

        return str_replace('{{routeName}}', $routeName, $functionString);
    }

    private function ensureActionsDirectoryExists(): void
    {
        $directory = $this->currentResourcePath($this->getPrefix());
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }

    private function ensureJsFileExists(string $fileName): string
    {
        $this->ensureActionsDirectoryExists();

        $filePath = $this->currentResourcePath($this->getPrefix().'/'.$fileName.'.js');

        if (! file_exists($filePath)) {
            $rawFileContent = '// Action file: '.$fileName.PHP_EOL;
            // $rawFileContent .= "import axios from 'axios'" . PHP_EOL . PHP_EOL;

            file_put_contents($filePath, $rawFileContent);
        }

        return $filePath;
    }

    private function getRequiredUrls(): array
    {
        $urls = [];
        foreach (Route::getRoutes() as $route) {
            if ($route->getPrefix() === $this->getPrefix()) {
                $urls[] = $route;
            }
        }

        return $urls;
    }

    private function getPrefix(): string
    {
        return 'action';
    }

    private function currentResourcePath(?string $additional = null): string
    {
        $baseResource = 'vendor/msamgan/lact/resources/';

        if ($additional) {
            return $baseResource.$additional;
        }

        return $baseResource;
    }
}
