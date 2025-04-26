<?php

declare(strict_types=1);

namespace Msamgan\Lact\Handlers;

use Illuminate\Support\Str;
use Msamgan\Lact\Concerns\CommonFunctions;
use Route;

class UrlHandler
{
    use CommonFunctions;

    public function actionUrls(): array
    {
        $urls = [];
        foreach (Route::getRoutes() as $route) {
            if (Str::plural($route->getPrefix()) === $this->getPrefix()) {
                $urls[] = $route;
            }
        }

        return $urls;
    }

    public function namedUrls(): array
    {
        $urls = [];
        foreach (Route::getRoutes() as $route) {
            if ($route->action['as'] ?? false) {
                $urls[] = [
                    'name' => $route->action['as'],
                    'uri' => $route->uri,
                ];
            }
        }

        return $urls;
    }

    public function extractNames(\Illuminate\Routing\Route $route): array
    {
        $uses = $route->getAction()['uses'];
        $pathArray = [];

        if (! is_string($uses)) {
            return [
                'fileName' => 'Closures',
                'methodName' => $this->dotCaseToFunctionCase($route->getName()),
                'pathArray' => $pathArray,
            ];
        }

        $usesFragments = explode('\\', $uses);
        $lastFragment = array_pop($usesFragments);

        $fileFragments = explode('@', $lastFragment);
        $fileName = $fileFragments[0];
        $methodName = $fileFragments[1];

        if (count($usesFragments) > 3) {
            $pathArray = array_slice($usesFragments, 3);
        }

        return [
            'fileName' => $fileName,
            'methodName' => $methodName,
            'pathArray' => $pathArray,
        ];
    }
}
