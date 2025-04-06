<?php

declare(strict_types=1);

namespace Msamgan\Lact\Handlers;

use Msamgan\Lact\Concerns\CommonFunctions;

class ContentHandler
{
    use CommonFunctions;

    public function createMethodString(string $file, array $replacers): string
    {
        $baseString = file_get_contents($this->currentSourcePath('Stubs/' . $file . '.stub'));

        foreach ($replacers as $key => $replacer) {
            $baseString = str_replace('{{' . $key . '}}', $replacer, $baseString);
        }

        return $baseString;
    }
}
