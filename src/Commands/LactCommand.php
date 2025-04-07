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
        // removing the actions' dir.
        $fileHandler->removeDirectoryRecursively();

        foreach ($urlHandler->actionUrls() as $route) {
            foreach ($route->methods as $method) {
                if ($method === 'HEAD') {
                    continue;
                }

                $this->process(urlHandler: $urlHandler, fileHandler: $fileHandler, contentHandler: $contentHandler, route: $route, file: $method);
            }
        }

        return self::SUCCESS;
    }

    private function process(
        UrlHandler $urlHandler, FileHandler $fileHandler, ContentHandler $contentHandler, Route $route, string $file
    ): void {
        $extraction = $urlHandler->extractNames(route: $route);
        $fileHandler->appendToFileWithEmptyLine(
            filePath: $fileHandler->ensureJsFileExists(fileName: $extraction['fileName']),
            content: $contentHandler->createMethodString(file: strtolower($file) . '_method', replacers: [
                'routeName' => $route->getName(),
                'methodName' => $extraction['methodName'],
            ])
        );
    }
}
