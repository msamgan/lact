<?php

declare(strict_types=1);

namespace Msamgan\Lact\Commands;

use Illuminate\Console\Command;
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
        foreach ($urlHandler->actionUrls() as $route) {
            $extraction = $urlHandler->extractNames(route: $route);
            $fileHandler->appendToFileWithEmptyLine(
                filePath: $fileHandler->ensureJsFileExists(fileName: $extraction['fileName']),
                content: $contentHandler->createGetMethodString(replacers: [
                    'routeName' => $route->getName(),
                    'methodName' => $extraction['methodName'],
                ])
            );
        }

        return self::SUCCESS;
    }
}
