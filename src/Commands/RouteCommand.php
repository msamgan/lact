<?php

declare(strict_types=1);

namespace Msamgan\Lact\Commands;

use Illuminate\Console\Command;
use Msamgan\Lact\Concerns\CommonFunctions;
use Msamgan\Lact\Handlers\ContentHandler;
use Msamgan\Lact\Handlers\FileHandler;
use Msamgan\Lact\Handlers\UrlHandler;

class RouteCommand extends Command
{
    use CommonFunctions;

    protected $signature = 'lact:routes';

    protected $description = 'Generate route function for the the named URLs';

    public function handle(FileHandler $fileHandler, UrlHandler $urlHandler, ContentHandler $contentHandler): int
    {
        $routeNameArray = [];
        foreach ($urlHandler->namedUrls() as $route) {
            $routeNameArray[] = $urlHandler->extractNameAndUri(route: $route);
        }

        $fileHandler->ensureJsFileExists(fileName: 'routes');
        $contentHandler->replaceJsonString(routes: $routeNameArray);

        return self::SUCCESS;
    }
}
