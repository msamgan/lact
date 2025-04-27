<?php

declare(strict_types=1);

namespace Msamgan\Lact\Commands;

use Exception;
use Illuminate\Console\Command;
use Msamgan\Lact\Concerns\CommonFunctions;

class LactCommand extends Command
{
    use CommonFunctions;

    public $signature = 'lact:run';

    public $description = 'Processes and builds actions for registered URLs in the application';

    /**
     * @throws Exception
     */
    public function handle(): int
    {
        passthru('./vendor/bin/lact');

        return self::SUCCESS;
    }
}
