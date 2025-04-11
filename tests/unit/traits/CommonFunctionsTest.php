<?php

declare(strict_types=1);

namespace Msamgan\Lact\Tests\unit\traits;

use Exception;
use Msamgan\Lact\Concerns\CommonFunctions;

class CommonFunctionsTest
{
    use CommonFunctions;
}

beforeEach(function () {
    $this->testClass = new CommonFunctionsTest();
});

it('tests getPrefix', function () {
    expect($this->testClass->getPrefix())->toBe('action');
});

it('tests currentResourcePath', function () {
    expect($this->testClass->currentResourcePath())->toBe('vendor/msamgan/lact/resources/')
        ->and($this->testClass->currentResourcePath('action'))->toBe('vendor/msamgan/lact/resources/action');
});

it('tests currentBasePath', function () {
    expect($this->testClass->currentBasePath())->toBe('vendor/msamgan/lact/')
        ->and($this->testClass->currentBasePath('resources'))->toBe('vendor/msamgan/lact/resources');
});

it('tests currentSourcePath', function () {
    expect($this->testClass->currentSourcePath())->toBe('vendor/msamgan/lact/src/')
        ->and($this->testClass->currentSourcePath('Attributes'))->toBe('vendor/msamgan/lact/src/Attributes');
});

it('tests dotCaseToFunctionCase', function () {
    expect($this->testClass->dotCaseToFunctionCase('action'))->toBe('action')
        ->and($this->testClass->dotCaseToFunctionCase('user.store'))->toBe('userStore')
        ->and($this->testClass->dotCaseToFunctionCase('user.store.password'))->toBe('userStorePassword')
        ->and($this->testClass->dotCaseToFunctionCase('User.Store.password'))->toBe('userStorePassword');
});

it('tests getActionAttributeName', function () {
    expect($this->testClass->getActionAttributeName())->toBe('Msamgan\Lact\Attributes\Action');
});

it('tests generateRandomUuid', function () {
    try {
        expect($this->testClass->generateRandomUuid())
            ->toBeString()
            ->and(strlen($this->testClass->generateRandomUuid()))->toBe(36)
            ->and($this->testClass->generateRandomUuid())->not->toEqual($this->testClass->generateRandomUuid());
    } catch (Exception $e) {
        //
    }
});

it('tests createRouteName', function () {
    expect($this->testClass->createRouteName('Http/Controllers/Settings/ProfileController', 'updateData'))->toBe('profile.update.data')
        ->and($this->testClass->createRouteName('Http/Controllers/DashboardController', 'data'))->toBe('dashboard.data');
});

it('tests functionCaseToDotCase', function () {
    expect($this->testClass->functionCaseToDotCase('userData'))->toBe('user.data')
        ->and($this->testClass->functionCaseToDotCase('userDataUpdate'))->toBe('user.data.update');
});

it('tests createArrayString', function () {
    expect($this->testClass->createArrayString(['auth', 'verified']))->toBeString()
        ->and($this->testClass->createArrayString(['auth', 'verified']))->toBe("['web', 'auth', 'verified']");
});

it('tests createParamString', function () {
    expect($this->testClass->createParamString(['user', 'task']))->toBeString()
        ->and($this->testClass->createParamString(['user', 'task']))->toBe('/{user}/{task}');
});
