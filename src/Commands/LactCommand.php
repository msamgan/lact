<?php

declare(strict_types=1);

namespace Msamgan\Lact\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Routing\Route;
use Msamgan\Lact\Concerns\CommonFunctions;
use Msamgan\Lact\Handlers\ContentHandler;
use Msamgan\Lact\Handlers\ControllerHandler;
use Msamgan\Lact\Handlers\FileHandler;
use Msamgan\Lact\Handlers\UrlHandler;
use ReflectionException;

class LactCommand extends Command
{
    use CommonFunctions;

    public $signature = 'lact:build-actions';

    public $description = 'Build actions for Urls';

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function handle(UrlHandler $urlHandler, FileHandler $fileHandler, ContentHandler $contentHandler, ControllerHandler $controllerHandler): int
    {
        $fileHandler->emptyLactRoutesFile();
        // this here process controller methods which are uses Action Attribute.
        $this->processRoutes(
            routes: $contentHandler->createRouteString(routeMeta: $controllerHandler->processController()),
            fileHandler: $fileHandler
        );

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
    ): void
    {
        $extraction = $urlHandler->extractNames(route: $route);
        $fileHandler->appendToFileWithEmptyLine(
            filePath: $fileHandler->ensureJsFileExists(fileName: $extraction['fileName']),
            content: $contentHandler->createMethodString(file: strtolower($file) . '_method', replacers: [
                'routeName' => $route->getName(),
                'methodName' => $extraction['methodName'],
            ])
        );
    }

    private function processRoutes(array $routes, FileHandler $fileHandler): void
    {
        foreach ($routes as $route) {
            $fileHandler->appendToFileWithEmptyLine(
                filePath: $this->currentBasePath('routes/lact.php'),
                content: $route
            );
        }
    }
}
