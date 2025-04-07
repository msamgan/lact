<?php

declare(strict_types=1);

namespace Msamgan\Lact\Concerns;

use Exception;
use Symfony\Component\Uid\Uuid;

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

    public function currentBasePath(?string $additional = null): string
    {
        $baseResource = 'vendor/msamgan/lact/';

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

    public function functionCaseToDotCase(string $input): string
    {
        $segments = preg_split('/(?=[A-Z])/', $input);
        $segments = array_map('lcfirst', $segments);

        return implode('.', $segments);
    }

    public function getActionAttributeName(): string
    {
        return 'Msamgan\Lact\Attributes\Action';
    }

    /**
     * Generates a random UUID (Universally Unique Identifier).
     *
     * @return string The generated UUID.
     *
     * @throws Exception If it was not possible to gather sufficient entropy.
     */
    public function generateRandomUuid(): string
    {
        return Uuid::v4()->toRfc4122();
    }

    public function createRouteName(string $controller, string $methodName): string
    {
        return strtolower(preg_replace('/Controller$/', '', class_basename($controller))) . '.' . $this->functionCaseToDotCase($methodName);
    }

    public function createArrayString(array $array): string
    {
        if (count($array) === 0) {
            return '[]';
        }

        $string = '[';

        foreach ($array as $key => $value) {
            $string .= "'$value',";
        }

        return $string . ']';
    }
}
