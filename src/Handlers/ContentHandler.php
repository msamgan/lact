<?php

namespace Msamgan\Lact\Handlers;

class ContentHandler
{
    public function createGetMethodString($routeName, $methodName): string
    {
        $baseString =
            "export const {{methodName}} = (queryString = {}) => {\n\treturn fetch(route('{{routeName}}', queryString)).then(response => response)\n}";

        $functionString = str_replace('{{methodName}}', $methodName, $baseString);

        return str_replace('{{routeName}}', $routeName, $functionString);
    }
}
