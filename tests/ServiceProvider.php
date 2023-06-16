<?php

use Illuminate\Config\Repository;
use TailwindMerge\Contracts\TailwindMergeContract;
use TailwindMerge\Laravel\ServiceProvider;
use TailwindMerge\TailwindMerge;

it('binds the tailwind merge on the container', function () {
    $app = app();

    $app->bind('config', fn () => new Repository([
        'tailwind-merge' => [
        ],
    ]));

    (new ServiceProvider($app))->register();

    expect($app->get(TailwindMerge::class))->toBeInstanceOf(TailwindMerge::class);
});

it('binds the client on the container as singleton', function () {
    $app = app();

    $app->bind('config', fn () => new Repository([
        'tailwind-merge' => [
        ],
    ]));

    (new ServiceProvider($app))->register();

    $twMerge = $app->get(TailwindMerge::class);

    expect($app->get(TailwindMerge::class))->toBe($twMerge);
});

it('uses the prefix from the configuration', function () {
    $app = app();

    $app->bind('config', fn () => new Repository([
        'tailwind-merge' => [
            'prefix' => 'tw-',
        ],
    ]));

    (new ServiceProvider($app))->register();

    $twMerge = $app->get(TailwindMerge::class);

    expect($twMerge->merge('tw-h-4 tw-h-6'))->toBe('tw-h-6');
});

it('provides', function () {
    $app = app();

    $provides = (new ServiceProvider($app))->provides();

    expect($provides)->toBe([
        TailwindMerge::class,
        TailwindMergeContract::class,
        'tailwind-merge',
    ]);
});
