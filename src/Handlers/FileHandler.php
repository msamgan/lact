<?php

declare(strict_types=1);

namespace Msamgan\Lact\Handlers;

use Msamgan\Lact\Concerns\CommonFunctions;

class FileHandler
{
    use CommonFunctions;

    public function ensureJsFileExists(string $fileName, ?string $filePath = null): string
    {
        $this->ensureActionsDirectoryExists($filePath);

        $filePath = $filePath
            ? $this->currentResourcePath($this->getPrefix() . DIRECTORY_SEPARATOR . $filePath . DIRECTORY_SEPARATOR . $fileName . '.js')
            : $this->currentResourcePath($this->getPrefix() . DIRECTORY_SEPARATOR . $fileName . '.js');

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

    public function emptyLactRoutesFile(): void
    {
        unlink($this->currentBasePath('routes/lact.php'));

        $this->ensureLactRoutesFileExists();
    }

    private function ensureActionsDirectoryExists(?string $filePath): void
    {
        $additionalPath = $this->getPrefix();
        if ($filePath) {
            $additionalPath = $additionalPath . DIRECTORY_SEPARATOR . $filePath;
        }

        $directory = $this->currentResourcePath($additionalPath);
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }

    private function ensureLactRoutesFileExists(): void
    {
        $this->ensureRoutesDirectoryExists();

        $filePath = $this->currentBasePath('routes/lact.php');
        if (! file_exists($filePath)) {
            file_put_contents($filePath, '<?php' . PHP_EOL . PHP_EOL);
        }
    }

    private function ensureRoutesDirectoryExists(): void
    {
        $directory = $this->currentBasePath('routes');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }
}
