<?php

declare(strict_types=1);

namespace Msamgan\Lact\Handlers;

use Msamgan\Lact\Concerns\CommonFunctions;
use Route;

class UrlHandler
{
    use CommonFunctions;

    public function actionUrls(): array
    {
        $urls = [];
        foreach (Route::getRoutes() as $route) {
            if ($route->getPrefix() === $this->getPrefix()) {
                $urls[] = $route;
            }
        }

        return $urls;
    }

    public function extractNames(\Illuminate\Routing\Route $route): array
    {
        $uses = $route->getAction()['uses'];

        if (! is_string($uses)) {
            return [
                'fileName' => 'Closures',
                'methodName' => $this->toSmallCamelCase($route->getAction()['as']),
            ];
        }

        $usesFragments = explode('\\', $uses);
        $lastFragment = array_pop($usesFragments);

        $fileFragments = explode('@', $lastFragment);
        $fileName = $fileFragments[0];
        $methodName = $fileFragments[1];

        return [
            'fileName' => $fileName,
            'methodName' => $methodName,
        ];
    }
}
