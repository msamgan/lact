<?php

declare(strict_types=1);

namespace Msamgan\Lact\Concerns;

trait CommonFunctions
{
    public function getPrefix(): string
    {
        return 'action';
    }

    public function currentResourcePath(?string $additional = null): string
    {
        $baseResource = 'vendor/msamgan/lact/resources/';

        if ($additional) {
            return $baseResource . $additional;
        }

        return $baseResource;
    }

    public function currentSourcePath(?string $additional = null): string
    {
        $baseResource = 'vendor/msamgan/lact/src/';

        if ($additional) {
            return $baseResource . $additional;
        }

        return $baseResource;
    }

    /**
     * Converts a string in dot case (e.g., "example.case") to function case
     * (e.g., "exampleCase").
     *
     * @param  string  $input  The input string formatted in dot case.
     * @return string The converted string formatted in function case.
     */
    public function dotCaseToFunctionCase(string $input): string
    {
        $segments = explode('.', $input);
        $segments = array_map('ucfirst', $segments);
        $segments[0] = lcfirst($segments[0]);

        return implode('', $segments);
    }
}
