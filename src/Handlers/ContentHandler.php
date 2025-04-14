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
        $file = match ($method) {
            'get', 'head' => 'get',
            'put', 'post', 'patch' => 'post',
            'delete' => 'delete'
        };

        $baseTemplate = file_get_contents($this->currentSourcePath('Stubs/template.stub'));
        $baseString = file_get_contents($this->currentSourcePath('Stubs/' . $file . '.stub'));

        $replacers['method'] = strtoupper($method);
        foreach ($replacers as $key => $replacer) {
            $baseString = str_replace('{{' . $key . '}}', $replacer, $baseString);
            $baseTemplate = str_replace('{{' . $key . '}}', $replacer, $baseTemplate);
        }

        return str_replace('{{function}}', $baseString, $baseTemplate);
    }

    /**
     * @throws Exception
     */
    public function createRouteString(array $routeMeta): array
    {
        $replacers = [];
        $routeStrings = [];
        foreach ($routeMeta as $value) {
            $path = $this->generateRandomUuid();

            if ($value['args']['path'] ?? null) {
                $path = trim($value['args']['path'], '/');
            }

            $method = 'get';
            if ($value['args']['method'] ?? null) {
                $method = strtolower($value['args']['method']);
            }

            $replacers[] = [
                'method' => $method,
                'path' => $path,
                'Controller' => $value['controller'],
                'methodName' => $value['methodName'],
                'routeName' => $value['args']['name'] ?? $this->createRouteName(controller: $value['controller'], methodName: $value['methodName']),
                'middleware' => $this->createArrayString(array: $value['args']['middleware'] ?? []),
                'params' => $this->createParamString(array: $value['args']['params'] ?? []),
            ];
        }

        foreach ($replacers as $replacer) {
            $baseString = file_get_contents($this->currentSourcePath('Stubs/route.stub'));
            foreach ($replacer as $key => $value) {
                $baseString = str_replace('{{' . $key . '}}', $value, $baseString);
            }

            $routeStrings[] = $baseString;
        }

        return $routeStrings;
    }
}
