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
            'put', 'post', 'patch', 'delete' => 'post',
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
            $routeStrings[] = $singleRouteReplacers['is_view']
                ? $this->runReplacers(template: $this->getStub(stubName: 'view_route'), replacers: $singleRouteReplacers)
                : $this->runReplacers(template: $this->getStub(stubName: 'route'), replacers: $singleRouteReplacers);
        }

        return $routeStrings;
    }

    public function replaceJsonString(array $routes): void
    {
        file_put_contents($this->currentResourcePath($this->getPrefix() . DIRECTORY_SEPARATOR . 'routes.js'), $this->runReplacers(
            $this->getStub(stubName: 'routejs'),
            [
                'jsonString' => json_encode($routes),
                'appUrl' => config('app.url'),
            ]
        ));
    }

    private function getBaseFunctionString(string $file, array $replacers): string
    {
        return $this->runReplacers(template: $this->getStub(stubName: $file), replacers: $replacers);
    }

    private function runReplacers(string $template, array $replacers): string
    {
        foreach ($replacers as $key => $replacer) {
            if (gettype($replacer) === 'boolean') {
                continue;
            }

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
            'is_view' => $meta['args']['isView'] ?? false,
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
        $path = $this->generateRandomWordString(meta: $meta);
        if ($meta['args']['path'] ?? null) {
            $path = trim($meta['args']['path'], '/');
        }

        return $path;
    }
}
