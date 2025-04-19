<?php

declare(strict_types=1);

namespace Msamgan\Lact\Handlers;

use Exception;
use Msamgan\Lact\Concerns\CommonFunctions;

class ContentHandler
{
    use CommonFunctions;

    public function createMethodString(string $method, array $replacers): string
    {
        $replacers['method'] = strtoupper($method);
        $replacers['methodLowerCase'] = $method;

        $file = match ($method) {
            'get', 'head' => 'get',
            'put', 'post', 'patch' => 'post',
            'delete' => 'delete'
        };

        $replacers['function'] = $this->getBaseFunctionString(file: $file, replacers: $replacers);
        $replacers['dataFunction'] = $method === 'get' ? $this->getDataFunctionString(replacers: $replacers) : '';

        return $this->runReplacers(template: $this->getStub(stubName: 'template'), replacers: $replacers);
    }

    /**
     * @throws Exception
     */
    public function createRouteString(array $routeMeta): array
    {
        $replacers = [];
        $routeStrings = [];
        foreach ($routeMeta as $value) {
            $replacers[] = $this->mapRouteReplacers(
                method: $this->getRouteMethod(meta: $value),
                path: $this->getRoutePath(meta: $value),
                meta: $value
            );
        }

        foreach ($replacers as $singleRouteReplacers) {
            $routeStrings[] = $this->runReplacers(template: $this->getStub(stubName: 'route'), replacers: $singleRouteReplacers);
        }

        return $routeStrings;
    }

    private function getBaseFunctionString(string $file, array $replacers): string
    {
        return $this->runReplacers(template: $this->getStub(stubName: $file), replacers: $replacers);
    }

    private function runReplacers(string $template, array $replacers): string
    {
        foreach ($replacers as $key => $replacer) {
            $template = str_replace('{{' . $key . '}}', $replacer, $template);
        }

        return $template;
    }

    private function getStub(string $stubName): string
    {
        return file_get_contents($this->currentSourcePath('Stubs/' . $stubName . '.stub'));
    }

    private function getDataFunctionString(array $replacers): string
    {
        return $this->runReplacers(template: $this->getStub(stubName: 'data'), replacers: $replacers);
    }

    private function mapRouteReplacers(string $method, string $path, array $meta): array
    {
        return [
            'method' => $method,
            'path' => $path,
            'Controller' => $meta['controller'],
            'methodName' => $meta['methodName'],
            'routeName' => $meta['args']['name'] ?? $this->createRouteName(controller: $meta['controller'], methodName: $meta['methodName']),
            'middleware' => $this->createArrayString(array: $meta['args']['middleware'] ?? []),
            'params' => $this->createParamString(array: $meta['args']['params'] ?? []),
        ];
    }

    private function getRouteMethod(array $meta): string
    {
        $method = 'get';
        if ($meta['args']['method'] ?? null) {
            $method = strtolower($meta['args']['method']);
        }

        return $method;
    }

    /**
     * @throws Exception
     */
    private function getRoutePath(array $meta): string
    {
        $path = $this->generateRandomUuid();
        if ($meta['args']['path'] ?? null) {
            $path = trim($meta['args']['path'], '/');
        }

        return $path;
    }
}
