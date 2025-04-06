<?php

declare(strict_types=1);

namespace Msamgan\Lact\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Route;
use Msamgan\Lact\Concerns\CommonFunctions;
use Msamgan\Lact\Handlers\ContentHandler;
use Msamgan\Lact\Handlers\FileHandler;
use Msamgan\Lact\Handlers\UrlHandler;

class LactCommand extends Command
{
    use CommonFunctions;

    public $signature = 'lact:build-actions';

    public $description = 'Build actions for Urls';

    public function handle(UrlHandler $urlHandler, FileHandler $fileHandler, ContentHandler $contentHandler): int
    {
        $methodsArray = [
            'GET',
            'POST',
        ];

        // removing the actions' dir.
        $fileHandler->removeDirectoryRecursively();

        foreach ($urlHandler->actionUrls() as $route) {
            foreach ($methodsArray as $method) {
                if ($urlHandler->checkFor($method, $route)) {
                    match ($method) {
                        'GET' => $this->handleGet($urlHandler, $fileHandler, $contentHandler, $route),
                        'POST' => $this->handlePost($urlHandler, $fileHandler, $contentHandler, $route),
                    };
                }
            }
        }

        return self::SUCCESS;
    }

    private function handleGet(UrlHandler $urlHandler, FileHandler $fileHandler, ContentHandler $contentHandler, Route $route): void
    {
        $extraction = $urlHandler->extractNames(route: $route);
        $fileHandler->appendToFileWithEmptyLine(
            filePath: $fileHandler->ensureJsFileExists(fileName: $extraction['fileName']),
            content: $contentHandler->createGetMethodString(replacers: [
                'routeName' => $route->getName(),
                'methodName' => $extraction['methodName'],
            ])
        );
    }

    private function handlePost(UrlHandler $urlHandler, FileHandler $fileHandler, ContentHandler $contentHandler, Route $route): void
    {
        $extraction = $urlHandler->extractNames(route: $route);
        $fileHandler->appendToFileWithEmptyLine(
            filePath: $fileHandler->ensureJsFileExists(fileName: $extraction['fileName']),
            content: $contentHandler->createPostMethodString(replacers: [
                'routeName' => $route->getName(),
                'methodName' => $extraction['methodName'],
            ])
        );
    }
}
