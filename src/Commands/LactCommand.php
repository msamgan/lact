<?php

namespace Msamgan\Lact\Commands;

use Illuminate\Console\Command;

class LactCommand extends Command
{
    public $signature = 'lact';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
