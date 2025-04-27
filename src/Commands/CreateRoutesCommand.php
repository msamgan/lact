<?php

declare(strict_types=1);

namespace Msamgan\Lact\Commands;

use Exception;
use Illuminate\Console\Command;
use Msamgan\Lact\Concerns\CommonFunctions;
use Msamgan\Lact\Handlers\ContentHandler;
use Msamgan\Lact\Handlers\ControllerHandler;
use Msamgan\Lact\Handlers\FileHandler;
use ReflectionException;

class CreateRoutesCommand extends Command
{
    use CommonFunctions;

    protected $signature = 'lact:create-routes';

    protected $description = 'Create routes from the #[Action] annotation';

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function handle(FileHandler $fileHandler, ContentHandler $contentHandler, ControllerHandler $controllerHandler): int
    {
        // this here process controller method that uses Action Attribute.
        $this->createRoutes(
            routes: $contentHandler->createRouteString(routeMeta: $controllerHandler->processController()),
            fileHandler: $fileHandler
        );

        return self::SUCCESS;
    }

    private function createRoutes(array $routes, FileHandler $fileHandler): void
    {
        foreach ($routes as $route) {
            $fileHandler->appendToFileWithEmptyLine(
                filePath: $this->currentBasePath('routes/lact.php'),
                content: $route
            );
        }
    }
}
