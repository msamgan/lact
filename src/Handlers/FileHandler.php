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
            file_put_contents($filePath, $content . PHP_EOL, FILE_APPEND);
        }
    }

    public function removeDirectoryRecursively(?string $directoryPath = null): void
    {
        if (! $directoryPath) {
            $directoryPath = $this->currentResourcePath($this->getPrefix());
        }

        if (! is_dir($directoryPath)) {
            return;
        }

        $items = array_diff(scandir($directoryPath), ['.', '..']);

        foreach ($items as $item) {
            $itemPath = $directoryPath . DIRECTORY_SEPARATOR . $item;

            if (is_dir($itemPath)) {
                $this->removeDirectoryRecursively($itemPath);
            } else {
                unlink($itemPath);
            }
        }

        rmdir($directoryPath);
    }

    private function ensureActionsDirectoryExists(): void
    {
        $directory = $this->currentResourcePath($this->getPrefix());
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }
}
