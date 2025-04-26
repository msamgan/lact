<?php

declare(strict_types=1);

namespace Msamgan\Lact\Concerns;

use Exception;
use Symfony\Component\Uid\Uuid;

trait CommonFunctions
{
    /**
     * Retrieves the prefix for the action.
     *
     * @return string The prefix string
     */
    public function getPrefix(): string
    {
        return 'actions';
    }

    /**
     * Constructs the current resource path by appending an optional additional string to the base resource path.
     *
     * @param  string|null  $additional
     *                                   An optional string to append to the base resource path.
     *                                   If null, only the base path will be returned.
     * @return string The constructed resource path.
     */
    public function currentResourcePath(?string $additional = null): string
    {
        $baseResource = 'vendor/msamgan/lact/resources/';

        if ($additional) {
            return $baseResource . $additional;
        }

        return $baseResource;
    }

    /**
     * Constructs the base path for the current resource by appending an optional additional string.
     *
     * This method is useful for dynamically forming paths within the `vendor/msamgan/lact` directory,
     * ensuring a consistent base path structure across the application.
     *
     * @param  string|null  $additional
     *                                   An optional string to append to the base resource path.
     *                                   If null, the method only returns the base path.
     * @return string The base resource path, with the optional appended string if provided.
     */
    public function currentBasePath(?string $additional = null): string
    {
        $baseResource = 'vendor/msamgan/lact/';

        if ($additional) {
            return $baseResource . $additional;
        }

        return $baseResource;
    }

    /**
     * Constructs the source path for the current resource by appending an optional additional string.
     *
     * This method is useful for dynamically forming paths within the `vendor/msamgan/lact/src/` directory,
     * ensuring a consistent base path structure when accessing source files in the application.
     *
     * @param  string|null  $additional
     *                                   An optional string to append to the base source path.
     *                                   If null, the method only returns the base source path.
     * @return string The base source path, with the optional appended string if provided.
     */
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

    /**
     * Retrieves the fully qualified name of the `Action` attribute class.
     *
     * This method provides the full namespace path for the `Action` attribute,
     * which can be used as metadata to describe or annotate specific behaviors
     * related to actions within the framework.
     *
     * @return string The fully qualified class name of the `Action` attribute.
     */
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

    /**
     * Creates a route name based on the given controller class name, including subdirectories, and method name.
     *
     * This method generates a route name string by:
     * - Extracting and formatting subdirectory names from the controller path
     * - Removing the trailing `Controller` from the controller's class name
     * - Converting the method name from a function case (e.g., "exampleMethod") to dot case (e.g., "example.method")
     *
     * @param  string  $controller  The fully qualified class name or path of the controller.
     *                              The name is normalized by stripping the `Controller` suffix.
     * @param  string  $methodName  The method name in the function case to be converted into a dot case.
     * @return string The generated route name in the format: "{subdirs}.{controller}.{method}".
     */
    public function createRouteName(string $controller, string $methodName): string
    {
        $parts = explode('/', $controller);
        $controllersIndex = array_search('Controllers', $parts);

        if ($controllersIndex !== false && count($parts) > $controllersIndex + 1) {
            $subdirs = array_slice($parts, $controllersIndex + 1, -1);
            $subdirs = array_map(function ($dir) {
                return strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $dir));
            }, $subdirs);

            if (! empty($subdirs)) {
                return implode('.', $subdirs) . '.' . strtolower(preg_replace('/Controller$/', '', class_basename($controller))) . '.' . $this->functionCaseToDotCase($methodName);
            }
        }

        return strtolower(preg_replace('/Controller$/', '', class_basename($controller))) . '.' . $this->functionCaseToDotCase($methodName);
    }

    /**
     * Converts a function case string (e.g., "exampleMethod") to a dot case
     * (e.g., "example.method").
     *
     * This method splits the input string into segments by identifying
     * uppercase letters as boundaries, converts each segment into lowercase,
     * and then joins them with dots to form the dot case format.
     *
     * @param  string  $input  The input string formatted in function case.
     * @return string The converted string formatted in dot case.
     */
    public function functionCaseToDotCase(string $input): string
    {
        $segments = preg_split('/(?=[A-Z])/', $input);
        $segments = array_map('lcfirst', $segments);

        return implode('.', $segments);
    }

    /**
     * Converts an associative array into an array string representation
     *
     * Example Usage:
     * ```php
     * $array = ['apple', 'banana', 'cherry'];
     * $result = $this->createArrayString($array);
     * // Returns: "['apple','banana','cherry']"
     * ```
     *
     * @param  array  $array  The input array to be converted into a string representation.
     * @return string The formatted array string.
     */
    public function createArrayString(array $array): string
    {
        if (count($array) === 0) {
            return "['web']";
        }

        $string = "['web', ";

        foreach ($array as $key => $value) {
            $string .= "'$value', ";
        }

        $string = rtrim($string, ', ');

        return $string . ']';
    }

    /**
     * Creates a parameter string based on the keys of the given array.
     *
     * Example Usage:
     * ```php
     * $params = ['user', 'id'];
     * $result = $this->createParamString($params);
     * // Returns: "/{user}/{id}"
     * ```
     *
     * @param  array  $array  The input array of parameter names to be converted into a string.
     *                        Each element represents a parameter name.
     * @return string The formatted parameter string, or an empty string if the input array is empty.
     */
    public function createParamString(array $array): string
    {
        if (count($array) === 0) {
            return '';
        }

        $string = '';
        foreach ($array as $key => $value) {
            $string .= '/';
            $string .= '{' . $value . '}';
        }

        return $string;
    }
}
