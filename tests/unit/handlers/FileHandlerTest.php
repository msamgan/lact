<?php

use Msamgan\Lact\Handlers\FileHandler;

beforeEach(function (): void {
    $this->fileHandler = new FileHandler();
});


it('checks for ensureJsFileExists', function () {
    $expects = $this->fileHandler->ensureJsFileExists(fileName: 'DashboardController');
    expect($expects)->toBeString()->toBe('vendor/msamgan/lact/resources/action/DashboardController.js');

    $expects = $this->fileHandler->ensureJsFileExists(fileName: 'ProfileController', filePath: implode('/', ['Settings']));
    expect($expects)->toBeString()->toBe('vendor/msamgan/lact/resources/action/Settings/ProfileController.js');

    $expects = $this->fileHandler->ensureJsFileExists(fileName: 'ProfileController', filePath: implode('/', ['Settings', 'User']));
    expect($expects)->toBeString()->toBe('vendor/msamgan/lact/resources/action/Settings/User/ProfileController.js');
});

it('checks for appendToFileWithEmptyLine', function () {
    $filePath = $this->fileHandler->ensureJsFileExists(fileName: 'UserController');
    $this->fileHandler->appendToFileWithEmptyLine(
        filePath: $filePath,
        content: 'Content Test',
    );

    expect(file_get_contents($filePath))->toBe('// Action file: UserController' . PHP_EOL . 'Content Test' . PHP_EOL);
});
