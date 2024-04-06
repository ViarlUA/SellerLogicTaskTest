<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->parallel();
    $rectorConfig->paths([
        __DIR__ . '/app',
        __DIR__ . '/tests',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/resources',
        __DIR__ . '/config',
        __DIR__ . '/lang',
    ]);

    // register a single rule
//    $rectorConfig->rule(InlineConstructorDefaultToPropertyRector::class);

    // define sets of rules
        $rectorConfig->sets([
            LevelSetList::UP_TO_PHP_83,
            LaravelSetList::LARAVEL_110
        ]);
};
