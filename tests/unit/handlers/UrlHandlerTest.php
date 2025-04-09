<?php

declare(strict_types=1);

use Msamgan\Lact\Handlers\UrlHandler;

beforeEach(function () {
    $this->urlHandler = new UrlHandler();
});

it('can give you all action URL', function () {
    $expects = $this->urlHandler->actionUrls();
    expect(count($expects))->toBe(1);
});

it('can give you names', function () {
    foreach ($this->urlHandler->actionUrls() as $route) {
        $expects = $this->urlHandler->extractNames($route);
        expect(count($expects))->toBe(3)->and(array_keys($expects))->toBe([
            0 => 'fileName',
            1 => 'methodName',
            2 => 'pathArray',
        ])->and(array_values($expects))->toBe([
            0 => 'DashboardController',
            1 => 'userUpdate',
            2 => []
        ])->and($expects['methodName'])->toBeCamelCase();
    }
});
