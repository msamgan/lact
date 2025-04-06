<?php

declare(strict_types=1);

namespace Msamgan\Lact\Handlers;

use Msamgan\Lact\Concerns\CommonFunctions;

class FileHandler
{
    use CommonFunctions;

    public function ensureJsFileExists(string $fileName): string
    {
        $this->ensureActionsDirectoryExists();

        $filePath = $this->currentResourcePath($this->getPrefix() . '/' . $fileName . '.js');

        if (! file_exists($filePath)) {
            file_put_contents($filePath, '// Action file: ' . $fileName . PHP_EOL);
        }

        return $filePath;
    }

    public function appendToFileWithEmptyLine(string $filePath, string $content): void
    {
        if (! str_contains(file_get_contents($filePath), $content)) {
            // Append the content followed by an empty line
            file_put_contents($filePath, $content . PHP_EOL . PHP_EOL, FILE_APPEND);
        }
    }

    private function ensureActionsDirectoryExists(): void
    {
        $directory = $this->currentResourcePath($this->getPrefix());
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }
}
