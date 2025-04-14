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

    protected $description = 'Clear routes and Action directory.';

    public function handle(FileHandler $fileHandler): int
    {
        $fileHandler->emptyLactRoutesFile();
        $fileHandler->removeDirectoryRecursively();

        return self::SUCCESS;
    }
}
