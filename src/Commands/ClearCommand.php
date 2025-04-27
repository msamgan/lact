<?php

declare(strict_types=1);

namespace Msamgan\Lact\Commands;

use Illuminate\Console\Command;
use Msamgan\Lact\Concerns\CommonFunctions;
use Msamgan\Lact\Handlers\FileHandler;

class ClearCommand extends Command
{
    use CommonFunctions;

    protected $signature = 'lact:clear';

    /**
     * This command is used to clear the route file and remove the Action directory.
     * It ensures that the necessary cleanup is performed for the LACT (Laravel Actions) package.
     */
    protected $description = 'Clear the routes file and remove the Action directory';

    public function handle(FileHandler $fileHandler): int
    {
        $fileHandler->emptyLactRoutesFile();
        $fileHandler->removeDirectoryRecursively();

        return self::SUCCESS;
    }
}
