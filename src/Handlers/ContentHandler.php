<?php

namespace Msamgan\Lact\Handlers;

use Msamgan\Lact\Concerns\CommonFunctions;

class ContentHandler
{
    use CommonFunctions;

    public function createGetMethodString(array $replacers): string
    {
        $baseString = file_get_contents($this->currentSourcePath('Stubs/get_method.stub'));

        foreach ($replacers as $key => $replacer) {
            $baseString = str_replace('{{' . $key . '}}', $replacer, $baseString);
        }

        return $baseString;
    }
}
