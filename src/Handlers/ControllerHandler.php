<?php

declare(strict_types=1);

namespace Msamgan\Lact\Handlers;

use Msamgan\Lact\Attributes\Action;
use Msamgan\Lact\Concerns\CommonFunctions;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use ReflectionException;
use ReflectionObject;

class ControllerHandler
{
    use CommonFunctions;

    /**
     * @throws ReflectionException
     */
    public function processController(): array
    {
        $routesMeta = [];
        $controllers = $this->getControllers();
        foreach ($controllers as $controller) {
            if ((new ReflectionClass($controller))->isInstantiable()) {
                $controllerInstance = app($controller);
                $reflection = new ReflectionObject($controllerInstance);
                foreach ($reflection->getMethods() as $method) {
                    $attributes = $method->getAttributes(Action::class);
                    if (count($attributes) > 0) {
                        foreach ($attributes as $attribute) {
                            if ($attribute->getName() === $this->getActionAttributeName()) {
                                $routesMeta[] = [
                                    'methodName' => $method->getName(),
                                    'controller' => $controllerInstance::class,
                                    'args' => $attribute->getArguments()
                                ];
                            }
                        }
                    }
                }
            }
        }

        return $routesMeta;
    }

    public function getControllers(): array
    {
        $controllersNamespace = 'App\Http\Controllers';
        $controllersPath = base_path('app/Http/Controllers');
        $controllerClasses = [];

        if (is_dir($controllersPath)) {
            $controllerFiles = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($controllersPath)
            );

            foreach ($controllerFiles as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $relativePath = str_replace([$controllersPath . DIRECTORY_SEPARATOR, '.php'], '', $file->getPathname());
                    $className = $controllersNamespace . '\\' . str_replace(DIRECTORY_SEPARATOR, '\\', $relativePath);

                    if (class_exists($className)) {
                        $controllerClasses[] = $className;
                    }
                }
            }
        }

        return $controllerClasses;
    }
}
