<?php

declare(strict_types=1);

namespace Msamgan\Lact\Attributes;

use Attribute;

#[Attribute]
class Action
{
    public function __construct(
        public string $method = 'get',
        public ?string $name = null,
        public ?string $path = null,
        public array $params = [],
        public array $middleware = [],
    ) {}
}
