<?php

declare(strict_types=1);

namespace Msamgan\Lact\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Msamgan\Lact\Lact
 */
class Lact extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Msamgan\Lact\Lact::class;
    }
}
