<?php

declare(strict_types=1);

namespace Msamgan\Lact\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Route;
use Msamgan\Lact\Concerns\CommonFunctions;
use Msamgan\Lact\Handlers\ContentHandler;
use Msamgan\Lact\Handlers\FileHandler;
use Msamgan\Lact\Handlers\UrlHandler;

class ProcessRoutesCommand extends Command
{
    use CommonFunctions;

    protected $signature = 'lact:process-routes';

    protected $description = 'Process routes create by #[Action] annotation and "action" prefix';

    public function handle(FileHandler $fileHandler, UrlHandler $urlHandler, ContentHandler $contentHandler): int
    {
        foreach ($urlHandler->actionUrls() as $route) {
            foreach ($route->methods as $method) {
                if ($method === 'HEAD') {
                    continue;
                }

                $this->processRoutes(urlHandler: $urlHandler, fileHandler: $fileHandler, contentHandler: $contentHandler, route: $route, method: $method);
            }
        }

        return self::SUCCESS;
    }

    private function processRoutes(
        UrlHandler $urlHandler, FileHandler $fileHandler, ContentHandler $contentHandler, Route $route, string $method
    ): void {
        $extraction = $urlHandler->extractNames(route: $route);
        $fileHandler->appendToFileWithEmptyLine(
            filePath: $fileHandler->ensureJsFileExists(fileName: $extraction['fileName'], filePath: implode('/', $extraction['pathArray'])),
            content: $contentHandler->createMethodString(method: strtolower($method), replacers: [
                'routeName' => $route->getName(),
                'methodName' => $extraction['methodName'],
            ])
        );
    }
}
